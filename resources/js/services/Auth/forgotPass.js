import { apiURL } from "@/utils/constants"

export default async function ForgotPass({ email }) {
  const response = await fetch(`${apiURL}auth/forgot-password`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ email }),
  })
    
  return await response.json()
}
