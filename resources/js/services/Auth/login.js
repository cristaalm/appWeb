import { apiURL } from "@/utils/constants"

export default async function AuthLogin({ user, pass, remember }) {
  const response = await fetch(`${apiURL}auth/login`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ user, pass, remember }),
  })
    
  return await response.json()
}
