import { apiURL } from "@/utils/constants"

export default async function updateUser({ user, token }) {
  const response = await fetch(`${apiURL}user/update`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify(user),
  })
    
  return await response.json()
}
