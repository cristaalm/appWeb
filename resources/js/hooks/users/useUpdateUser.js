import update from '@/services/Users/updateuser'
import { inject, ref } from 'vue'

export function useUpdateUser() {
  const loading = ref(false)
  const showToast = inject('showToast')

  const updateUser = async user => {
    loading.value = true
    try {
      const response = await update({ user: user, token: localStorage.getItem('access_token') })

      if (response.success) {
        showToast({ message: response.message, tipo: 'success', duration: 4000 })
        
        return true
      }
      showToast({ message: response.message || (response.errors ?? 'Error al intentar actualizar el usuario.'), tipo: 'error', duration: 4000 })
      
      return false
    } catch (error) {
      console.error('Error al intentar actualizar el usuario:', error)
      showToast({ message: 'Error al intentar actualizar el usuario.', tipo: 'error', duration: 4000 })
      
      return false
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    updateUser,
  }
}
