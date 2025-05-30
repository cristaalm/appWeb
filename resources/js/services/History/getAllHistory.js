import { apiURL } from "@/utils/constants"

export default async function getAllHistory({ perPage, page, sortBy, token, fechaInicio, fechaFin, tipoDispositivo, id_empresa }) {
  const url = new URL(`${apiURL}logs/all`);
  url.searchParams.set('per_page', perPage);
  url.searchParams.set('page', page);
  url.searchParams.set('key', sortBy[0]?.key || '');
  url.searchParams.set('order', sortBy[0]?.order || '');
  url.searchParams.set('fecha_inicio', fechaInicio);
  url.searchParams.set('fecha_fin', fechaFin);
  url.searchParams.set('tipo_dispositivo', tipoDispositivo);
  url.searchParams.set('id_empresa', id_empresa);

  const response = await fetch(url, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
  })
    
  return await response.json()
}
