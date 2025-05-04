import AuthResetPassword from '@/services/Auth/resetPassword'
import { messageError } from '@/utils/constants'
import { inject, ref } from 'vue'


export default function useResetPassword() {
  const success = ref(false)
  const loading = ref(false)
  const showToast = inject('showToast')

  const resetState = () => {
    success.value = false
    loading.value = false
  }

  const validate = ({ newPassword, confirmPassword }) => {
    if (!newPassword || !confirmPassword) {
      showToast({ message: 'Por favor, complete los campos', tipo: 'warning' })
        
      return false
    }

    if (newPassword.length < 8) {
      showToast({ message: 'La contraseña debe tener al menos 8 caracteres', tipo: 'warning' })
        
      return false
    }

    if (newPassword !== confirmPassword) {
      showToast({ message: 'Las contraseñas no coinciden', tipo: 'warning' })
        
      return false
    }

    return true
  }

  const resetPassword = async form => {
    const { newPassword, confirmPassword, token, email } = form
    if (!validate({ newPassword, confirmPassword })) return
    resetState()
    loading.value = true

    try {
      const response = await AuthResetPassword({ newPassword, confirmPassword, token, email })

      if (response.status !== 200) {
        showToast({ message: response.message ?? messageError, tipo: 'error', duration: 4000 })
        
        return
      }

      success.value = true
      showToast({ message: 'Contraseña restablecida con éxito', tipo: 'success', duration: 4000 })
    } catch (error) {
      console.error(error)
      showToast({ message: messageError, tipo: 'error', duration: 4000 })
    } finally {
      loading.value = false
    }
  }

  return {
    success,
    loading,
    resetPassword,
  }
}
