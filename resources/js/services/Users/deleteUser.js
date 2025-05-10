import { apiURL } from "@/utils/constants"

export default async function deleteUser({ user, token }) {
  const response = await fetch(`${apiURL}user/delete`, {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify({ id: user.id }),
  })
    
  return await response.json()
}
