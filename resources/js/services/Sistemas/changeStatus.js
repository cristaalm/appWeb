import { apiURL } from "@/utils/constants"

export default async function changeStatus({ token, id_empresa, estado }) {
  const response = await fetch(`${apiURL}empresa/change-status`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify({ id_empresa, estado }),
  })
    
  return await response.json()
}
