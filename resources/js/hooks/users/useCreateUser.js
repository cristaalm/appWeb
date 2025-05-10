import create from '@/services/Users/createUser'
import { inject, ref } from 'vue'

export function useCreateUser() {
  const loading = ref(false)
  const showToast = inject('showToast')

  const createUser = async user => {
    loading.value = true
    try {
      const response = await create({ user: user, token: localStorage.getItem('access_token') })

      if (response.success) {
        showToast({ message: response.message, tipo: 'success', duration: 4000 })
        
        return true
      }
      showToast({ message: response.message || (response.errors ?? 'Error al intentar insertar el usuario.'), tipo: 'error', duration: 4000 })
      
      return false
    } catch (error) {
      console.error('Error al intentar insertar el usuario:', error)
      showToast({ message: 'Error al intentar insertar el usuario.', tipo: 'error', duration: 4000 })
      
      return false
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    createUser,
  }
}
