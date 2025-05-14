import getLastMonth  from "@/services/History/lastMonth";
import { ref, inject } from "vue";

export default function useLastMonth() {
    const data = ref([])
    const profitLoss = ref(null)
    const current = ref(null)
    const loading = ref(false)
    const error = ref(null)
    const first = ref(true)
    const showToast = inject("showToast");

    const loadLastMonthData = async (idDispositivo) => {
        loading.value = true
        try {
            const response = await getLastMonth({ token: localStorage.getItem("access_token"), idDispositivo });
            data.value = response.data.data;
            profitLoss.value = response.data.profitloss;
            current.value = response.data.current;
        } catch (e) {
            error.value = e;
            showToast({ message: e.message, tipo: "error", duration: 4000 });
            console.log(e);
        } finally {
            loading.value = false
            first.value = false
        }
    };

    return {
        data,
        profitLoss,
        current,
        loading,
        error,
        first,
        loadLastMonthData
    }
}
