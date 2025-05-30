import { apiURL } from "@/utils/constants"

export default async function updateSystem({ token, sistema }) {
  const formData = new FormData()
  Object.keys(sistema).forEach(key => formData.append(key, sistema[key]))

  const response = await fetch(`${apiURL}empresa/update`, {
    method: "POST",
    headers: {
      Authorization: `Bearer ${token}`,
    },
    body: formData,
  })
    
  return await response.json()
}
