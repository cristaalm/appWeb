<script setup>
import { ref, computed, onMounted, inject } from 'vue'
import LoadingIcon from '@/components/Base/LoadingIcon'
import CardSystem from './cardSystem.vue'
import CreateSystem from './newSystemModal'
import UpdateSystem from './updateSystemModal'
import DeleteSystem from './deleteSystemModal'

const { sistemas, loading, loadAllSistemas, first } = inject('sistemas')
const filtro = ref('')
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
    const coincideTexto =
      sistema.nombre_comercial.toLowerCase().includes(filtro.value.toLowerCase()) ||
      sistema.razon_social.toLowerCase().includes(filtro.value.toLowerCase()) ||
      sistema.rfc.toLowerCase().includes(filtro.value.toLowerCase())
    if (activeTab.value === "activos") return coincideTexto && sistema.estado
    if (activeTab.value === "inactivos") return coincideTexto && !sistema.estado
    return coincideTexto
  })
})

const showCreateModal = ref(false)

const openCreateModal = () => {
  showCreateModal.value = true
}

const handleStatusChange = (newSistema) => {
  // remplazamos el sistema en la lista
  sistemas.value = sistemas.value.map((sistema) => {
    if (sistema.id_empresa === newSistema.id_empresa) {
      return newSistema
    }
    return sistema
  })

  loadAllSistemas()
}

const handleUpdate = (newSistema) => {
  sistemas.value = sistemas.value.map((sistema) => {
    if (sistema.id_empresa === newSistema.id_empresa) {
      return newSistema
    }
    return sistema
  })
  loadAllSistemas()
}

const handleDelete = (id_empresa) => {
  sistemas.value = sistemas.value.filter((sistema) => sistema.id_empresa !== id_empresa)
  loadAllSistemas()
}

const handleCreate = (newSistema) => {
  sistemas.value.push(newSistema)
  loadAllSistemas()
}

const showUpdateModal = ref(false)
const sistemaToUpdate = ref({})

const openUpdateModal = (sistema) => {
  sistemaToUpdate.value = sistema
  showUpdateModal.value = true
}

const sistemaToDelete = ref({})
const showDeleteModal = ref(false)

const openDeleteModal = (sistema) => {
  sistemaToDelete.value = sistema
  showDeleteModal.value = true
}

onMounted(() => {
  loadAllSistemas()
})
</script>

<template>
  <div class="py-6 space-y-6 w-full">
    <!-- Header y botón nuevo -->
    <div class="flex flex-col gap-4 justify-between items-start md:flex-row md:items-center">
      <div>
        <h1 class="text-3xl font-bold tracking-tight">Gestión de Sistemas</h1>
        <p class="mt-1 text-muted-foreground">Administra las empresas que utilizan tu plataforma</p>
      </div>
      <div class="flex gap-2">
        <!-- boton para recargar -->
         
        <VBtn
          variant="text"
          class="!text-gray-500 hover:!text-blue-600 dark:!text-gray-300 dark:hover:!text-white transition-all duration-200"
          icon
          :loading="loading" 
          title="Refrescar"
          @click="() => loadAllSistemas(true)"
        >
          <VIcon
            icon="bx-refresh"
            class="text-xl"
          />
        </VBtn>
        <VBtn class="ml-auto" @click="openCreateModal">
          <VIcon class="mr-2" icon="bx-plus" />
          Nuevo Sistema
        </VBtn>
      </div>
    </div>
    <!-- Buscador y Tabs -->
    <div class="flex flex-col gap-4 justify-between items-center md:flex-row">
      <div class="relative w-full md:w-96">
        <VIcon icon="mdi-magnify" class="absolute top-2.5 left-2.5 w-4 h-4 text-muted-foreground" />
        <VInput
          placeholder="Buscar por nombre, razón social o RFC..."
          class="pl-8"
          v-model="filtro"
        />
      </div>
      <div class="flex gap-4 items-center w-full md:w-auto">
        <VTabs v-model="activeTab" show-arrows class="w-full v-tabs-pill md:w-auto">
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
    </div>

    <!-- Resultados -->
    <div v-if="loading && first" class="flex flex-col gap-4 justify-center items-center py-12">
      <LoadingIcon icon="tail-spin" class="w-16 h-16 text-primary"  />
      <p class="ml-2 text-lg font-medium">Cargando...</p>
    </div>
    <div v-else-if="sistemasFiltrados.length === 0" class="flex flex-col justify-center items-center py-12 text-center">
      <VIcon icon="mdi-office-building" class="mb-4 w-12 h-12 text-muted-foreground" />
      <h3 class="text-lg font-medium">No se encontraron sistemas</h3>
      <p class="mt-1 text-muted-foreground">Intenta con otros términos de búsqueda o agrega un nuevo sistema</p>
    </div>
    <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
      <CardSystem
        v-for="sistema in sistemasFiltrados"
        :key="sistema.id"
        :sistema="sistema"
        @changeStatus="handleStatusChange"
        @handleUpdate="openUpdateModal"
        @handleDelete="openDeleteModal"
      />
    </div>
  </div>

  <CreateSystem v-model="showCreateModal" @create="handleCreate" />
  <UpdateSystem v-model="showUpdateModal" @update="handleUpdate" :sistema="sistemaToUpdate" />
  <DeleteSystem v-model="showDeleteModal" @deleted="handleDelete" :sistema="sistemaToDelete" />
</template>
