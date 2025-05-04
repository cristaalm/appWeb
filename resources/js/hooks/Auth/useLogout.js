import Logout from '@/services/Auth/logout'
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
export default function useLogout() {
  const router = useRouter()
  const successLogout = ref(false)
  const errorLogout = ref(false)
  const loadingLogout = ref(false)
  const showToast = inject('showToast')
    
  const resetState = () => {
    successLogout.value = false
    errorLogout.value = null
    loadingLogout.value = false
  }

  const nextLogout = () => {
    localStorage.removeItem('access_token')
    localStorage.removeItem('user')
    localStorage.removeItem('expires_at')
    router.push('/login')
  }

  const logoutUser = async () => {
    resetState()
    loadingLogout.value = true

    const token = localStorage.getItem('access_token')
    if (!token) {
      errorLogout.value = true
      showToast({ message: 'No tiene una sesión activa', tipo: 'error', duration: 4000 })
      nextLogout()
      
      return
    }

    try {
      const response = await Logout({ token })

      if (response.status !== 200) {
        errorLogout.value = true
        showToast({ message: response.message ?? messageError, tipo: 'error', duration: 4000 })
        
        return
      }
      successLogout.value = true
      showToast({ message: 'Sesión cerrada correctamente', tipo: 'success', duration: 4000 })
      nextLogout()
      
    } catch (error) {
      errorLogout.value = true
      console.log(error)
      showToast({ message: messageError, tipo: 'error', duration: 4000 })
    } finally {
      loadingLogout.value = false
    }
  }

  return {
    successLogout,
    errorLogout,
    loadingLogout,
    logoutUser,
  }
}
