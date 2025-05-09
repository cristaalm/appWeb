import { apiURL } from "@/utils/constants";

export default async function updateDevice({ token, device }) {
    const response = await fetch(`${apiURL}dispositivo/update`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`,
        },
        body: JSON.stringify(device),
    })
    
    return await response.json()
}
