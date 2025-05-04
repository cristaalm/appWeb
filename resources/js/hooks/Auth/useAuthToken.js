import AuthToken from '@/services/Auth/token'
import { ref } from 'vue'

export default function useAuthToken() {
  const user = ref(null)
  const success = ref(false)
  const error = ref(false)
  const loading = ref(false)
    
  const resetState = () => {
    success.value = false
    error.value = null
    loading.value = false
  }

  const authToken = async () => {
    const token = localStorage.getItem('access_token')
    if (!token) return false
    resetState()
    loading.value = true
    
    try {
      const response = await AuthToken({ token })

      if (response.status !== 200) {
        error.value = true

        return false
      }
      success.value = true

      const data = response.data
      
      user.value = data.user
      localStorage.setItem('user', JSON.stringify(data.user))
      localStorage.setItem('expires_at', data.expires_at)

      return true

    } catch (error) {
      error.value = true
      console.log(error)
    } finally {
      loading.value = false
    }

    return false
  }

  return {
    user,
    success,
    error,
    loading,
    authToken,
  }
}
