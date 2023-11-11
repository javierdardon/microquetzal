export function useNavLinks() {
    const links = [
      {
        name: 'Inicio',
        link: '/',
        type: 'Link'
      },
      {
        name: 'Productos',
        link: '/productos',
        type: 'Link'
      },
      {
        name: 'Micro Quetzal Nacional',
        link: '/Logo.svg',
        type: 'Image'
      },
      {
        name: 'Equipos',
        link: '/equipos',
        type: 'Link'
      },
      {
        name: 'Nosotros',
        link: '/nosotros',
        type: 'Link'
      }
    ];
    return  links
  }
