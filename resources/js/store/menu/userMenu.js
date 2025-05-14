import { defineStore } from 'pinia'

const useMenuStore = defineStore('menu', {
  state: () => ({
    value: [],
  }),
  actions: {
    async loadMenu(user) {
      if (!user || !user.nivel ) return []
        
      this.value = user.nivel == 1 ? this.adminAquanovaMenu() : this.userMenu()
    },
    userMenu() {
      return [
        {
          title: 'Panel',
          icon: 'bx-bxs-dashboard',
          to: '/panel',
        },
      ]
    },
    adminAquanovaMenu() {
      return [
        {
          title: 'Panel',
          icon: 'bx bxs-dashboard',
          to: '/panel',
        },
        'Configuración de AquaNova',
        {
          title: 'Usuarios',
          icon: 'bx bxs-user-detail', // Más representativo para gestión de usuarios
          to: '/panel/usuarios',
        },
        {
          title: 'Dispositivos',
          icon: 'bx bxs-chip', // Representa hardware o dispositivos electrónicos
          to: '/panel/dispositivos',
        },
        {
          title: 'Sistemas',
          icon: 'bx bxs-cog', // Representa configuración o sistemas
          to: '/panel/sistemas',
        },
      ];
    },
  },
})

export default useMenuStore
