import { apiURL } from "@/utils/constants"

export default async function createSystem({ token, data }) {
    const formData = new FormData()
    Object.keys(data).forEach(key => formData.append(key, data[key]))

    const response = await fetch(`${apiURL}empresa/create`, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
        },
        body: formData,
    })
    return await response.json()
}
