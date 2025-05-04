import { defineStore } from 'pinia'

const useMenuStore = defineStore('menu', {
  state: () => ({
    value: [],
  }),
  actions: {
    async loadMenu(user) {
      if (!user || !user.permissions ) return []
        
      this.value = user.permissions.includes(1) ? this.adminVelorMenu() : this.userMenu()
    },
    userMenu() {
      return [
        {
          title: 'Panel',
          icon: 'bx-bxs-dashboard',
          to: '/panel',
        },
        'Mi Perfil',
        {
          title: 'Mi información',
          icon: 'bx-user',
          to: '/perfil/informacion',
        },
        {
          title: 'Gestion de tiempo',
          icon: 'bx-time-five',
          to: '/perfil/tiempo',
        },
        {
          title: 'Tareas',
          icon: 'bx-task',
          to: '/perfil/tareas',
        },
        'Empresa',
        {
          title: 'Organigrama',
          icon: 'bx-building-house',
          to: '/empresa/organigrama',
        },
        {
          title: 'Directorio',
          icon: 'bx-user-pin',
          to: '/empresa/directorio',
        },
        {
          title: 'Comunicación',
          icon: 'bx-chat',
          to: '/empresa/comunicacion',
        },
        {
          title: 'Reclutamiento',
          icon: 'bx-user-plus',
          menu: [
            {
              title: 'Reclutamiento y seleccion',
              to: '/empresa/reclutamiento',
            },
            {
              title: 'Onboarding',
              to: '/empresa/onboarding',
            },
          ],
        },
        {
          title: 'Capacitaciones',
          icon: 'bx-book-reader',
          to: '/empresa/capacitacion',
        },
        {
          title: 'Clima Laboral',
          icon: 'bx-smile',
          to: '/empresa/clima',
        },
        {
          title: 'Evaluación de desempeño',
          icon: 'bx-star',
          to: '/empresa/evaluacion',
        },
        'Configuraciones',
        {
          title: 'Configuración de uniama',
          icon: 'bx-cog',
          menu: [
            {
              title: 'Sistema',
              to: '/configuracion/sistema',
            },
            {
              title: 'Catalogos',
              to: '/configuracion/catalogos',
            },
            {
              title: 'Clientes',
              to: '/configuracion/clientes',
            },
            {
              title: 'Corporativos',
              to: '/configuracion/corporativos',
            },
            {
              title: 'Actualizaciones',
              to: '/configuracion/actualizaciones',
            },
          ],
        },
      ]
    },
    adminVelorMenu() {
      return [
        {
          title: 'Panel',
          icon: 'bx-bxs-dashboard',
          to: '/panel',
        },
        'Configuración de uniama',
        {
          title: 'Catalogos',
          icon: 'bx-purchase-tag-alt',
          menu: [
            {
              title: 'Documentos',
              to: '/configuracion/catalogos/documentos',
            },
            {
              title: 'Ausencias',
              to: '/configuracion/catalogos/ausencias',
            },
            {
              title: 'Paises',
              to: '/configuracion/catalogos/paises',
            },
          ],
        },
      ]
    },
  },
})

export default useMenuStore
