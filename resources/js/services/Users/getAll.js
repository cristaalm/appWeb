import { apiURL } from "@/utils/constants"

export default async function getAllUsers({ perPage, page, query, sortBy, token, status }) {
  let url = `${apiURL}user/all/?per_page=${perPage}&page=${page}&query=${query}&key=${sortBy[0]?.key || ''}&order=${sortBy[0]?.order || ''}`
  if (status !== undefined && status !== '') {
    url += `&status=${status}`
  }

  const response = await fetch(url, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
  })

  return await response.json()
}
