export default adminVelorMenu = [
  {
    title: 'Tablero General',
    icon: 'mdi-view-dashboard',
    to: '/tablero',
  },
  {
    title: 'Catalogos',
    icon: 'mdi-book-open-page-variant',
    menu: [
      {
        title: 'Documentos',
        to: '/catalogos/documentos',
      },
      {
        title: 'Ausencias',
        to: '/catalogos/ausencias',
      },
      {
        title: 'Paises',
        to: '/catalogos/paises',
      },
      {
        title: 'Estados',
        to: '/catalogos/estados',
      },
      {
        title: 'Municipios',
        to: '/catalogos/municipios',
      },
      {
        title: 'Colonias',
        to: '/catalogos/colonias',
      },
      {
        title: 'Regimen Fiscal',
        to: '/catalogos/regimen-fiscal',
      },
    ], 
  },
]
