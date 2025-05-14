import { apiURL } from "@/utils/constants";

export default async function getLastMonth({ token, idDispositivo }) {
    const response = await fetch(`${apiURL}logs/last-month`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`,
        },
        body: JSON.stringify({ id_dispositivo: idDispositivo })
    })
    
    return await response.json()
}
