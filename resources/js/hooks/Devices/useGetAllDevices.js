import getAllDevices  from "@/services/Devices/getAll";
import { ref, inject } from "vue";

export default function useGetAllDevices() {
    const devices = ref([])
    const loading = ref(false)
    const error = ref(null)
    const first = ref(true)
    const showToast = inject("showToast");

    const loadAllDevices = async () => {
        loading.value = true
        try {
            const response = await getAllDevices({ token: localStorage.getItem("access_token") });
            devices.value = response.data;
        } catch (e) {
            error.value = e;
            showToast({ message: e.message, tipo: "error", duration: 4000 });
        } finally {
            loading.value = false
            first.value = false
        }
    };

    return {
        devices,
        loading,
        error,
        first,
        loadAllDevices
    }
}
