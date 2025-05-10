<script setup>
import Button from '@/components/Base/Button/Button.vue'
import { Popover } from '@/components/Base/Headless'
import Lucide from '@/components/Base/Lucide/Lucide.vue'
import OrderTable from '@/components/orderTable/'
import { useAllUsers } from '@/hooks/users/useAllUsers'
import { computed, onMounted, inject } from 'vue'
import CreateUserModal from './createUserModal.vue'
import EditUserModal from './updateuserModal.vue'
import DeleteUserModal from './deleteUserModal.vue'


// ####### UTILS TABLE ####### //

const {
  users,
  total,
  loading,
  page,
  perPage,
  sortBy,
  search,
  loadUsers,
} = useAllUsers()

const selectedStatus = ref(null)

const catalogSystem = inject('catalogSystem')

watch(selectedStatus, () => {
  loadUsers({ status: selectedStatus.value })
})

const headers = [
  { title: 'Usuario', key: 'username', align: 'center', sortable: true },
  { title: 'Nombre', key: 'name' },
  { title: 'Correo', key: 'email' },
  { title: 'Estado', key: 'estado', align: 'center', sortable: true },
  { title: 'Nivel', key: 'nivel', align: 'center', sortable: true },
  { title: 'Empresa', key: 'empresa', align: 'center', sortable: true },
  { title: '', key: 'actions', sortable: false, align: 'end' },
]

// ####### MODALS ####### //

const showEditModal = ref(false)
const selectedUser = ref(null)

const openEditModal = doc => {
  selectedUser.value = doc
  showEditModal.value = true
}

const showCreateModal = ref(false)

const openCreateModal = () => {
  showCreateModal.value = true
}

const showDeleteModal = ref(false)
const selectedUserToDelete = ref(null)

const openDeleteModal = doc => {
  selectedUserToDelete.value = doc
  showDeleteModal.value = true
}

// ####### FILTERS ####### //

const activeFilters = computed(() => {
  const filters = []
  if (selectedStatus.value !== null) {
    filters.push(selectedStatus.value === 1 ? 1 : 0)
  }

  return filters.length
})

const currentUser = JSON.parse(localStorage.getItem('user'))

onMounted(() => {
  loadUsers()
  catalogSystem.loadCatalog()
})
</script>

<template>
  <div class="p-6 space-y-6 bg-gray-50 dark:bg-[#013134]">
    <!-- Header -->
    <div class="flex flex-col gap-4 justify-between items-start sm:flex-row sm:items-center">
      <div>
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-slate-200">
           <span class="text-blue-600 dark:text-slate-200">Usuarios</span> 
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-slate-300">
          Administra los usuarios del sistema.
        </p>
      </div>
      <div class="flex gap-3">
        <VBtn
          variant="text"
          class="!text-gray-500 hover:!text-blue-600 dark:!text-gray-300 dark:hover:!text-white transition-all duration-200"
          icon
          title="Refrescar"
          @click="loadUsers"
        >
          <VIcon
            icon="bx-refresh"
            class="text-xl"
          />
        </VBtn>
        <Popover
          v-slot="{ close }"
          class="inline-block"
        >
          <!-- eslint-disable-next-line vue/component-name-in-template-casing -->
          <Popover.Button 
            :as="Button" 
            variant="outline-secondary" 
            class="w-full sm:w-auto"
          >
            <Lucide 
              icon="ArrowDownWideNarrow" 
              class="stroke-[1.3] w-4 h-4 mr-2" 
            />
            Filtrar
            <div class="flex justify-center items-center px-1.5 ml-2 h-5 text-xs font-medium rounded-full border bg-slate-100 dark:text-black">
              {{ activeFilters }}
            </div>
          </Popover.Button>
          <!-- eslint-disable-next-line vue/component-name-in-template-casing -->
          <Popover.Panel placement="bottom-end bg dark:bg-[#013134]">
            <div class="p-2 space-y-4 dark:bg-[#013134]">
              <div>
                <div class="text-left text-slate-500 dark:text-slate-200">
                  Estado
                </div>
                <select
                  v-model="selectedStatus"
                  class="flex-1 px-2 py-1 mt-2 w-full bg-white rounded border transition-colors duration-200 text-slate-900 border-slate-300 dark:bg-[#013134] dark:text-slate-200 dark:border-slate-600 focus:ring-2 focus:ring-primary-500 focus:outline-none"
                >
                  <option :value="null">
                    Todos
                  </option>
                  <option :value="1">
                    Activo
                  </option>
                  <option :value="0">
                    Inactivo
                  </option>
                </select>
              </div>
              <div class="flex items-center mt-4">
                <VBtn
                  variant="elevated"
                  color="primary"
                  class="ml-auto w-32 dark:bg-[#3a9291] hover:dark:bg-[#3a9291]/80 dark:!text-white"
                  @click="close"
                >
                  Cerrar
                </VBtn>
              </div>
            </div>
          </Popover.Panel>
        </Popover>
        
        <VBtn
          class="!bg-gradient-to-tr !text-white shadow-lg text-sm font-semibold"
          variant="elevated"
          @click="openCreateModal"
        >
          <VIcon
            icon="bx-plus"
            class="me-2"
          />
          Nuevo Usuario
        </VBtn>
      </div>
    </div>
    <div class="flex gap-2 justify-end items-center mb-4">
      <!-- Filtro de Estado -->
    </div>
    <!-- Tabla de Estados -->
    <OrderTable
      :headers="headers"
      :items="users"
      :loading="loading"
      :page="page"
      :per-page="perPage"
      :total="total"
      :sort-by="sortBy"
      :search="search"
      @update:page="page = $event"
      @update:per-page="perPage = $event"
      @update:sort-by="sortBy = $event"
      @update:search="search = $event"
    >
      <template #item.estado="{ item }">
        <span
          class="px-3 py-1 text-xs font-medium rounded-full shadow-sm"
          :class="item.estado ? 'bg-green-100 text-green-700 dark:bg-green-600 dark:text-green-100' : 'bg-red-100 text-red-700 dark:bg-red-600 dark:text-red-100'"
        >
          {{ item.estado ? 'Activo' : 'Inactivo' }}
        </span>
      </template>
      <template #item.nivel="{ item }">
        {{ item.nivel == 1 ? 'Admin' : item.nivel == 2 ? 'Usuario' : 'Desconocido' }}
      </template>
      <template #item.actions="{ item }">
        <VIcon
          v-if="item.id == currentUser.id"
          icon="bx-user"
          class="text-blue-500 me-2"
          @click="openEditModal(item)"
        />
        <VMenu
        v-else
          offset="10"
          location="bottom end"
          width="200"
        >
          <template #activator="{ props }">
            <VBtn
              icon
              v-bind="props"
              variant="plain"
              class="!text-gray-500 hover:!text-gray-800 dark:hover:text-white"
            >
              <VIcon
                icon="bx-dots-vertical-rounded"
                class="dark:hover:text-white dark:text-white"
              />
            </VBtn>
          </template>
          <VList>
            <VListItem @click="openEditModal(item)">
              <template #prepend>
                <VIcon
                  icon="bx-edit"
                  class="me-2"
                />
              </template>
              <VListItemTitle>Editar</VListItemTitle>
            </VListItem>
            <VDivider />
            <VListItem @click="openDeleteModal(item)">
              <template #prepend>
                <VIcon
                  icon="bx-trash"
                  class="text-red-500 me-2"
                />
              </template>
              <VListItemTitle class="text-red-500">
                Eliminar
              </VListItemTitle>
            </VListItem>
          </VList>
        </VMenu>
      </template>
    </OrderTable>
  </div>
  
  
    <EditUserModal
    v-model="showEditModal"
    :user="selectedUser"
    :catalogSystem="catalogSystem"
    @update="e => { if (e) loadUsers() }"
    /> 
 
  <CreateUserModal
    v-model="showCreateModal"
    :catalogSystem="catalogSystem"
    @create="e => { if (e) loadUsers() }"
  />
  <DeleteUserModal
    v-model="showDeleteModal"
    :user="selectedUserToDelete"
    @delete="e => { if (e) loadUsers() }"
  />
</template>
