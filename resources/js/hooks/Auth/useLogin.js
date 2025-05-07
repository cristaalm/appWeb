import AuthLogin from '@/services/Auth/login'
import { messageError } from '@/utils/constants'
import { inject, ref } from 'vue'
import { useRouter } from 'vue-router'

/**
 * Custom hook for handling user login functionality.
 * 
 * @returns {Object} An object containing the following properties and methods:
 * - `user` {Ref<null|Object>} - A reactive reference to the logged-in user data.
 * - `success` {Ref<boolean>} - A reactive reference indicating if the login was successful.
 * - `error` {Ref<boolean>} - A reactive reference indicating if there was an error during login.
 * - `loading` {Ref<boolean>} - A reactive reference indicating if the login process is in progress.
 * - `loginUser` {Function} - A function to handle the login process.
 */
export default function useLogin() {
  const router = useRouter()
  const userRef = ref(null)
  const success = ref(false)
  const error = ref(false)
  const loading = ref(false)
  const showToast = inject('showToast')
    
  const resetState = () => {
    success.value = false
    error.value = null
    loading.value = false
  }

  const validate = ({ user, pass }) => {
    if (!user || !pass) {
      error.value = true
      showToast({ message: 'Por favor, complete los campos', tipo: 'warning' })
      
      return false
    }
    
    return true
  }

  const loginUser = async form => {
    const { user, pass, remember } = form
    if (!validate({ user, pass })) return
    resetState()
    loading.value = true
    
    try {
      const response = await AuthLogin({ user, pass, remember })

      if (!response.success) {
        error.value = true
        showToast({ message: response.message ?? messageError, tipo: 'error', duration: 4000 })
        
        return
      }
      success.value = true

      const data = response.data
      
      userRef.value = data.user
      localStorage.setItem('access_token', data.access_token)
      localStorage.setItem('user', JSON.stringify(data.user))
      localStorage.setItem('expires_at', data.expires_at)

      setTimeout(() => {
        router.push('/panel')
      }, 1000)

    } catch (error) {
      error.value = true
      console.log(error)
      showToast({ message: messageError, tipo: 'error', duration: 4000 })
    } finally {
      loading.value = false
    }
  }

  return {
    user: userRef,
    success,
    error,
    loading,
    loginUser,
  }
}
