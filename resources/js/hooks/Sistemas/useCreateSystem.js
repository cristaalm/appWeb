import create from "@/services/Sistemas/createSystem";

export default function useCreateSystem() {
    const loading = ref(false);
    const error = ref(null);
    const showToast = inject("showToast");

    const createSystem = async (data) => {
        loading.value = true;
        try {
            const response = await create({ token: localStorage.getItem("access_token"), data });
            return response;
        } catch (e) {
            error.value = e;
            console.log(e)
            showToast({ message: e.message, tipo: "error", duration: 4000 });
        } finally {
            loading.value = false;
        }
    };

    return {
        loading,
        error,
        createSystem,
    };
}
    