import { ref, inject } from "vue";
import getAll from "@/services/devicesSistem/getAll";

export default function useAllDevices() {
    const loading = ref(false);
    const dispositivos = ref([]);
    const error = ref(null);
    const showToast = inject("showToast");
    const first = ref(true)

    const loadAllDevices = async (id_empresa) => {
        loading.value = true
        try {
            const response = await getAll({ token: localStorage.getItem("access_token"), id_empresa });
            dispositivos.value = response.data;
        } catch (e) {
            error.value = e;
            showToast({ message: e.message, tipo: "error", duration: 4000 });
        } finally {
            loading.value = false
            first.value = false
        }
    };

    return {
        first,
        loading,
        dispositivos,
        error,
        loadAllDevices,
    };
}
