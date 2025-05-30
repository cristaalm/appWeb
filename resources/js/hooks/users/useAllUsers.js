import getAllUsers from '@/services/Users/getAll'
import { useDebounceFn } from '@vueuse/core'
import { inject, ref, watch } from 'vue'

export function useAllUsers() {
  const users = ref([])
  const total = ref(0)
  const loading = ref(false)

  const page = ref(1)
  const perPage = ref(5)
  const search = ref('')
  const sortBy = ref([{ key: null, order: null }])

  const showToast = inject('showToast')

  const loadUsers = async (params = {}) => {
    loading.value = true
    try {
      const response = await getAllUsers({
        page: page.value,
        query: search.value,
        perPage: perPage.value,
        sortBy: sortBy.value,
        token: localStorage.getItem('access_token'),
        ...params,
      })

      if (response.success) {
        users.value = response.data.users?.data || []
        total.value = response.data.users?.total || 0
        if (page.value > response.data.users.last_page) page.value = response.data.users.last_page
      } else {
        users.value = []
        total.value = 0
        showToast({ message: response.message || (response.errors ?? 'Error al cargar Usuarios'), tipo: 'error', duration: 4000 })
      }
    } catch (error) {
      console.error('Error al cargar Usuarios:', error)
      showToast({ message: 'Error al cargar Usuarios', tipo: 'error', duration: 4000 })
    } finally {
      loading.value = false
    }
  }

  const debouncedLoad = useDebounceFn(loadUsers, 500)

  watch([page, perPage, sortBy], loadUsers, { immediate: true })
  watch(search, debouncedLoad)

  return {
    users,
    total,
    loading,
    page,
    perPage,
    sortBy,
    search,
    loadUsers,
  }
}
