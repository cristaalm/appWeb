import { ref, inject } from 'vue'
import update from '@/services/Devices/updateDevice'

export default function useUpdateDevice() {
    const showToast = inject("showToast");
    const loading = ref(false)
    const error = ref(null)
    const first = ref(true)

    const updateDevice = async (device) => {
        loading.value = true
        try {
            const response = await update({ token: localStorage.getItem("access_token"), device })
            if (response.data.id_dispositivo == 3) {
                response.message = "Temperatura actualizada correctamente"
            } else if (response.data.id_dispositivo == 6) {
                response.message = "Humedad actualizada correctamente"
            }
            showToast({ message: response.message, tipo: "success", duration: 4000 })
        } catch (e) {
            error.value = e
            showToast({ message: e.message, tipo: "error", duration: 4000 })
        } finally {
            loading.value = false
            first.value = false
        }
    }

    return {
        loading,
        error,
        first,
        updateDevice
    }
}
