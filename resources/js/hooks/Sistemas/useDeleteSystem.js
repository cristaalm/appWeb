import deleteSys from '@/services/Sistemas/deleteSystem'
import { ref, inject } from 'vue'

export default function useDeleteSystem() {
    const loading = ref(false)
    const error = ref(null)
    const showToast = inject("showToast")

    const deleteSystem = async (id_empresa) => {
        loading.value = true
        try {
            const response = await deleteSys({ token: localStorage.getItem("access_token"), id_empresa })
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
        deleteSystem
    }
}
