import { apiURL } from "@/utils/constants";

export default async function getAllDevices({ token }) {
    const response = await fetch(`${apiURL}dispositivo/all`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`,
        },
    })
    
    return await response.json()
}
