import { apiURL } from "@/utils/constants"

export default async function getCatalog({ token }) {
  let url = `${apiURL}empresa/catalog`

  const response = await fetch(url, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
  })

  return await response.json()
}
