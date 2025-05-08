import { apiURL } from "@/utils/constants"

export default async function deleteSystem({ token, id_empresa }) {
    const response = await fetch(`${apiURL}empresa/delete`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({ id_empresa }),
    })
    
    return await response.json()
}
