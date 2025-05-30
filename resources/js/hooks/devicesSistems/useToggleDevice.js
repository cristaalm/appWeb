import { ref, inject } from "vue";
import toggle from "@/services/devicesSistem/toggleDevice";

export default function useToggleDevice() {
    const loading = ref(false);
    const error = ref(null);
    const showToast = inject("showToast");
    const currentDevice = ref(0)

    const toggleDevice = async (id_empresa, id_dispositivo) => {
        loading.value = true
        currentDevice.value = id_dispositivo
        try {
            const response = await toggle({ token: localStorage.getItem("access_token"), id_empresa, id_dispositivo });
            showToast({ message: response.message, tipo: "success", duration: 4000 });
        } catch (e) {
            error.value = e;
            showToast({ message: e.message, tipo: "error", duration: 4000 });
        } finally {
            loading.value = false
            currentDevice.value = 0
        }
    };

    return {
        loading,
        error,
        toggleDevice,
        currentDevice
    };
}
