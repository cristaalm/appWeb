import getCatalog from '@/services/Sistemas/getCatalog'
import { inject, ref } from 'vue'

export default function useCatalogSystem() {
  const catalog = ref([])
  const loading = ref(false)

  const showToast = inject('showToast')

  const loadCatalog = async () => {
    loading.value = true
    try {
      const response = await getCatalog({
        token: localStorage.getItem('access_token'),
      })

      if (response.success) {
        catalog.value = response.data || []
      } else {
        catalog.value = []
        showToast({ message: response.message || (response.errors ?? 'Error al cargar Catalogo'), tipo: 'error', duration: 4000 })
      }
    } catch (error) {
      console.error('Error al cargar Catalogo:', error)
      showToast({ message: 'Error al cargar Catalogo', tipo: 'error', duration: 4000 })
    } finally {
      loading.value = false
    }
  }

  return {
    catalog,
    loading,
    loadCatalog,
  }
}
