import { apiURL } from "@/utils/constants"

export default async function AuthToken({ token }) {
  const response = await fetch(`${apiURL}auth/token`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify({}),
  })
    
  return await response.json()
}
