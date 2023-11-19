
const toggleSidebar = ( e ) => {
   e.preventDefault();

   const logoSidebar = document.querySelector('#logo-sidebar')
   if(!logoSidebar) return;

   const isOpen = logoSidebar.dataset.isOpen === 'true';

   if (isOpen) {
      logoSidebar.classList.add('-translate-x-full');
      logoSidebar.classList.remove('transform-none');
      logoSidebar.dataset.isOpen = 'false';
   } else {
      logoSidebar.classList.remove('-translate-x-full');
      logoSidebar.classList.add('transform-none');
      logoSidebar.dataset.isOpen = 'true';
   }

}

export const dashboardSidebar = () => {
   const buttonSidebar = document.querySelector('#button-sidebar');
   if( buttonSidebar ) buttonSidebar.addEventListener('click', toggleSidebar)
}