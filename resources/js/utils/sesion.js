export function logoutSesion() {
  localStorage.removeItem('access_token')
  localStorage.removeItem('user')
  localStorage.removeItem('expires_at')
}
