import { apiURL } from "@/utils/constants"

export default async function createUser({ user, token }) {
  const response = await fetch(`${apiURL}user/register`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify(user),
  })
    
  return await response.json()
}
