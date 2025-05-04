import ForgotPass from '@/services/Auth/forgotPass'
import { messageError } from '@/utils/constants'
import { inject, ref } from 'vue'

export default function useForgotPass() {
  const success = ref(false)
  const error = ref(false)
  const loading = ref(false)
  const showToast = inject('showToast')
    
  const resetState = () => {
    success.value = false
    error.value = null
    loading.value = false
  }

  const validate = ({ email }) => {
    if (!email) {
      error.value = true
      showToast({ message: 'Por favor, complete los campos', tipo: 'warning' })
      
      return false
    }
    
    return true
  }

  const sendEmail = async form => {
    const { email } = form
    if (!validate({ email })) return
    resetState()
    loading.value = true
    
    try {
      const response = await ForgotPass({ email })

      if (response.status !== 200) {
        error.value = true
        showToast({ message: response.message ?? messageError, tipo: 'error', duration: 4000 })
        
        return
      }
      success.value = true

    } catch (error) {
      error.value = true
      console.log(error)
      showToast({ message: messageError, tipo: 'error', duration: 4000 })
    } finally {
      loading.value = false
    }
  }

  return {
    success,
    error,
    loading,
    sendEmail,
  }
}
