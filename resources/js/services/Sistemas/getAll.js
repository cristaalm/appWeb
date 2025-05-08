import { apiURL } from "@/utils/constants"

export default async function getAll({ token }) {
  const response = await fetch(`${apiURL}empresa/all`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
  })
    
  return await response.json()
}
