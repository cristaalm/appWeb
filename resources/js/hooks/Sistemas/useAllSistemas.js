import { ref, inject } from "vue";
import getAll from "@/services/Sistemas/getAll";

export default function useAllSistemas() {
    const loading = ref(false);
    const sistemas = ref([]);
    const error = ref(null);
    const showToast = inject("showToast");
    const first = ref(true)

    const loadAllSistemas = async () => {
        loading.value = true
        try {
            const response = await getAll({ token: localStorage.getItem("access_token") });
            sistemas.value = response.data;
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
        sistemas,
        error,
        loadAllSistemas,
    };
}
