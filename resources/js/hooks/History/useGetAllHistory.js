import getAllHistory from '@/services/History/getAllHistory'
import { useDebounceFn } from '@vueuse/core'
import { inject, ref, watch } from 'vue'

export function useAllHistory(selectedTypeDevice) {
  const history = ref([])
  const total = ref(0)
  const loading = ref(false)

  const page = ref(1)
  const perPage = ref(10)
  const sortBy = ref([{ key: 'fecha_ingreso', order: 'desc' }])

  const fecha = ref('dd/mm/yyyy - dd/mm/yyyy')
  const tipoDispositivo = ref(selectedTypeDevice)

  const showToast = inject('showToast')

  const loadHistory = async () => {
    loading.value = true
    try {
        const [fechaInicio, fechaFin] = fecha.value.split(' - ').map(dateString => {
            const date = new Date(dateString)
            return isNaN(date.getTime()) ? null : date.toISOString().split('T')[0]
        })

        const filters = {
            page: page.value,
            perPage: perPage.value,
            sortBy: sortBy.value,
            token: localStorage.getItem('access_token'),
            fechaInicio,
            fechaFin,
            tipoDispositivo: tipoDispositivo.value
        }

        const response = await getAllHistory(filters)

        if (response.success) {
            history.value = response.data?.data || []
            total.value = response.data?.total || 0
        } else {
            history.value = []
            total.value = 0
            showToast({ message: response.message || (response.errors ?? 'Error al cargar Historial'), tipo: 'error', duration: 4000 })
        }

        if (page.value > response.data.last_page) page.value = response.data.last_page
      
    } catch (error) {
        console.error('Error al cargar Historial:', error)
        showToast({ message: 'Error al cargar Historial', tipo: 'error', duration: 4000 })
    } finally {
        loading.value = false
    }
  }

  watch([page, perPage, sortBy], loadHistory, { immediate: true })
  watch([fecha, tipoDispositivo], loadHistory, { immediate: true })

  return {
    history,
    total,
    loading,
    page,
    perPage,
    sortBy,
    fecha,
    tipoDispositivo,
    loadHistory,
  }
}
