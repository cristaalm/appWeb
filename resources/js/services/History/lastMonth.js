import { apiURL } from "@/utils/constants";

export default async function getLastMonth({ token, idDispositivo, id_empresa }) {
    const response = await fetch(`${apiURL}logs/last-month`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`,
        },
        body: JSON.stringify({ id_dispositivo: idDispositivo, id_empresa })
    })
    
    return await response.json()
}
