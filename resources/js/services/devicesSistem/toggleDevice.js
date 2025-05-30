import { apiURL } from "@/utils/constants"

export default async function toggleDevice({ token, id_empresa, id_dispositivo }) {
  const response = await fetch(`${apiURL}dispositivo-empresa/toggle`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify({ id_empresa, id_dispositivo }),
  })
    
  return await response.json()
}
