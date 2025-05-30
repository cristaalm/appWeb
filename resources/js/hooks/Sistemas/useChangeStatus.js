import { ref, inject } from "vue";
import changeStatus from "@/services/Sistemas/changeStatus";

export default function useChangeStatus() {
    const loading = ref(false);
    const error = ref(null);
    const showToast = inject("showToast");

    const changeStatusSistema = async (id, estado) => {
        loading.value = true;
        try {
            const response = await changeStatus({ token: localStorage.getItem("access_token"), id_empresa: id, estado });
            return response;
        } catch (e) {
            error.value = e;
            showToast({ message: e.message, tipo: "error", duration: 4000 });
            return false;
        } finally {
            loading.value = false;
        }
    }

    return {
        loading,
        error,
        changeStatusSistema 
    }
}
