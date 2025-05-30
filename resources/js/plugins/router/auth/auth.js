const Auth = [
  {
    path: 'login',
    component: () => import('@/pages/Auth/login.vue'),
  },
  {
    path: 'forgot-password',
    component: () => import('@/pages/Auth/forgotPass.vue'),
  },
  {
    path: 'reset-password', // example: 
    component: () => import('@/pages/Auth/resetPass.vue'),
    props: route => ({ token: route.query.token, email: route.query.email }),
  },
]

export default Auth
