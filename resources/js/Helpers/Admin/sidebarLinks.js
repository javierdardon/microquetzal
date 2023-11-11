export const routes = [
  {
    name: 'Dashboard',
    route: 'admin/',
    icon: 'ic:round-dashboard'
  },
  {
    name: 'Productos',
    route: 'admin/products',
    icon: 'game-icons:jigsaw-box'
  },
  {
    name: 'Productos destacados',
    route: 'admin/products/featured',
    icon: 'icon-park-outline:star-one',
  },
  {
    name: 'Marcas',
    route: 'admin/brands',
    icon: 'cib:nvidia',
  },
  {
    name: 'Categorías',
    route: 'admin/categories',
    icon: 'gis:folder-maps',
  },
  {
    name: 'PC Combos',
    route: 'admin/builds',
    icon: 'teenyicons:hd-screen-solid'

  },
  {
    name: 'Combos destacados',
    route: 'admin/builds/featured',
    icon: 'simple-icons:pcgamingwiki',
  },
  {
    name: 'Pedidos',
    route: 'admin/orders',
    icon: 'bi:box-fill',
  },
  {
    name: 'Configuración',
    route: 'admin/configurations',
    icon: 'basil:settings-solid',
  },
  {
    name: 'Cerrar sesión',
    route: 'logout',
    icon: 'clarity:logout-solid',
    method: 'post'
  },
];
