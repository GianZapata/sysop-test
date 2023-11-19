import { loginPage, registerPage } from "./auth";
import { editUserPage, createUserPage } from './dashboard/users'
import { dashboardSidebar } from './dashboard/ui'

const initEventListeners = () => {
   loginPage();
   registerPage();
   editUserPage();
   createUserPage();
   dashboardSidebar();
}

document.addEventListener('DOMContentLoaded', initEventListeners);
