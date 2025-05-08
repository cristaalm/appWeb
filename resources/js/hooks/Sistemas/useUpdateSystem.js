import update from '@/services/Sistemas/updateSystem'
import { ref, inject } from 'vue'

export default function useUpdateSystem() {
    const loading = ref(false)
    const error = ref(null)
    const showToast = inject("showToast")

    const updateSystem = async (sistema) => {
        loading.value = true
        try {
            const response = await update({ token: localStorage.getItem("access_token"), sistema })
            return response
        } catch (e) {
            error.value = e
            showToast({ message: e.message, tipo: "error", duration: 4000 })
            return false
        } finally {
            loading.value = false
        }
    }

    return {
        loading,
        error,
        updateSystem
    }
}
