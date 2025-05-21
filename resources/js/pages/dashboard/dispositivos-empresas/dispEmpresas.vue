<script setup>
import { ref, computed, onMounted, inject } from 'vue'
import SistemaCard from './cardSystem.vue'

const injectedSistemas = inject('sistemas', null)

// Datos locales en caso de que no se inyecten
const sistemas = injectedSistemas?.sistemas || ref([
  {
    id: 1,
    nombre_comercial: 'Empresa Uno',
    razon_social: 'Empresa Uno S.A. de C.V.',
    rfc: 'EUN123456789',
    estado: true,
    logotipo: '',
  },
  {
    id: 2,
    nombre_comercial: 'Empresa Dos',
    razon_social: 'Empresa Dos S.A. de C.V.',
    rfc: 'EDO987654321',
    estado: true,
    logotipo: '',
  },
  {
    id: 3,
    nombre_comercial: 'Empresa Tres',
    razon_social: 'Empresa Tres S.A. de C.V.',
    rfc: 'ETR456789123',
    estado: false,
    logotipo: '',
  }
])

// Usa las funciones inyectadas o crea locales si no hay inyección
const loading = injectedSistemas?.loading || ref(false)
const first = injectedSistemas?.first || ref(true)
const loadAllSistemas = injectedSistemas?.loadAllSistemas || ((refresh = false) => {
  loading.value = true
  //carga de datos
  setTimeout(() => {
    loading.value = false
    first.value = false
  }, 1000)
})

const activeTab = ref('todos')
const tabs = [
  {
    title: 'Todos',
    icon: 'bx-list-check',
    tab: 'todos',
  },
  {
    title: 'Activos',
    icon: 'bx-check-circle',
    tab: 'activos',
  },
  {
    title: 'Inactivos',
    icon: 'bx-x-circle',
    tab: 'inactivos',
  },
]

const sistemasFiltrados = computed(() => {
  return sistemas.value.filter((sistema) => {
    if (activeTab.value === "activos") return sistema.estado
    if (activeTab.value === "inactivos") return !sistema.estado
    return true
  })
})

onMounted(() => {
  loadAllSistemas()
})
</script>

<template>
  <div class="py-6 space-y-6 w-full">
    <!-- Header -->
    <div class="flex flex-col gap-4 justify-between items-start md:flex-row md:items-center">
      <div>
        <h1 class="text-3xl font-bold tracking-tight">Gestión de Sistemas Y Sus Dispositivos</h1>
        <p class="mt-1 text-muted-foreground">Administra los dispositivos de las empresas que utilizan tu plataforma</p>
      </div>
    </div>

    <!-- Filtros -->
    <div class="flex justify-end">
      <VTabs v-model="activeTab" show-arrows class="v-tabs-pill">
        <VTab
          v-for="item in tabs"
          :key="item.tab"
          :value="item.tab"
        >
          <VIcon size="20" start :icon="item.icon" />
          {{ item.title }}
        </VTab>
      </VTabs>
    </div>

    <!-- Resultados -->
    <div v-if="loading && first" class="flex flex-col gap-4 justify-center items-center py-12">
      <LoadingIcon icon="tail-spin" class="w-16 h-16 text-primary" />
      <p class="ml-2 text-lg font-medium">Cargando...</p>
    </div>
    <div v-else-if="sistemasFiltrados.length === 0" class="flex flex-col justify-center items-center py-12 text-center">
      <VIcon icon="mdi-office-building" class="mb-4 w-12 h-12 text-muted-foreground" />
      <h3 class="text-lg font-medium">No se encontraron sistemas</h3>
      <p class="mt-1 text-muted-foreground">No hay sistemas disponibles en esta categoría</p>
    </div>
    <div v-else class="flex flex-wrap gap-6">
      <div
        v-for="sistema in sistemasFiltrados"
        :key="sistema.id"
        class="w-full md:w-1/2 lg:w-1/3"
      >
        <SistemaCard :sistema="sistema" />
      </div>
    </div>

  </div>
</template>
