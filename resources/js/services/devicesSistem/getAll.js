import { apiURL } from "@/utils/constants"

export default async function getAll({ token, id_empresa }) {
  const response = await fetch(`${apiURL}dispositivo-empresa/all`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify({ id_empresa }),
  })
    
  return await response.json()
}
