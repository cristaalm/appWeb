import { apiURL } from "@/utils/constants"

export default async function Logout({ token }) {
  const response = await fetch(`${apiURL}auth/logout`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
  })
    
  return await response.json()
}
