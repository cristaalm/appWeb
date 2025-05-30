import { apiURL } from "@/utils/constants"

export default async function AuthResetPassword({ newPassword, confirmPassword, token, email }) {
  const response = await fetch(`${apiURL}auth/reset-password`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ email, password: newPassword, "password_confirmation": confirmPassword, token }),
  })
    
  return await response.json()
}
