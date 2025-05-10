import deleteUsers from '@/services/Users/deleteUser'
import { inject, ref } from 'vue'

export function useDeleteUser() {
  const loading = ref(false)
  const showToast = inject('showToast')

  const deleteUser = async user => {
    loading.value = true
    try {
      const response = await deleteUsers({ user: user, token: localStorage.getItem('access_token') })

      if (response.success) {
        showToast({ message: response.message, tipo: 'success', duration: 4000 })
        
        return true
      }
      showToast({ message: response.message || (response.errors ?? 'Error al intentar eliminar el documento.'), tipo: 'error', duration: 4000 })
      
      return false
    } catch (error) {
      console.error('Error al intentar eliminar el documento:', error)
      showToast({ message: 'Error al intentar eliminar el documento.', tipo: 'error', duration: 4000 })
      
      return false
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    deleteUser,
  }
}
