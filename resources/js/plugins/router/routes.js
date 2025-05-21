import useAuthToken from '@/hooks/Auth/useAuthToken'
import { logoutSesion } from '@/utils/sesion'
import { ref } from 'vue'
import Auth from './auth/auth'


const flagAuth = ref(false)

export const routes = [
  {
    path: '/',
    component: () => import('@/layouts/blank.vue'),
    beforeEnter: async (to, from, next) => {
      const accessToken = localStorage.getItem('access_token')
  
      if (!accessToken) {
        flagAuth.value = false
        logoutSesion()
        next()
        return
      }
  
      const { authToken } = useAuthToken()
      const isValid = await authToken()
      if (!isValid) {
        logoutSesion()
        flagAuth.value = false
        next()
        return
      }
          
      localStorage.setItem('user', JSON.stringify(authToken.user))
      flagAuth.value = true
      next('/panel')
      return
    },
    children: [
      ...Auth, // Rutas de autenticación
      {
        path: '/',
        component: () => import('@/pages/LandingPage.vue'),
      },
      {
        path: '/:pathMatch(.*)*',
        component: () => import('@/pages/[...error].vue'),
      },
    ],
  },
  {
    path: '/panel',
    component: () => import('@/layouts/default.vue'),
    beforeEnter: async (to, from, next) => {
      const accessToken = localStorage.getItem('access_token')

      if (!accessToken) {
        next('/login')
        flagAuth.value = false
        logoutSesion()

        return
      } else if (flagAuth.value) {
        flagAuth.value = false
      }

      // si existe verificamos si el token es válido
      const { authToken } = useAuthToken()
      const isValid = await authToken()
      if (!isValid) {
        logoutSesion()
        flagAuth.value = false
        next('/login')
        
        return
      }
      flagAuth.value = true
      next()
    },
    children: [
      {
        path: '',
        redirect: '/panel/usuarios',
      },
      {
        path: 'sistemas',
        component: () => import('@/pages/dashboard/sistema/sistemaView.vue'),
      },
      {
        path: 'dispositivos',
        component: () => import('@/pages/dashboard/dispositivos/devicesView.vue'),
      },
      {
        path: 'usuarios',
        component: () => import('@/pages/dashboard/usuarios/usersView.vue'),
      },
      {
        path: 'dispositivos-empresa',
        component: () => import('@/pages/dashboard/dispositivos-empresas/dispEmpresas.vue'),
      }
    ],
  },
]
