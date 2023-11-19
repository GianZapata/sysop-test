import Swal from 'sweetalert2'
import axios from 'axios'

import { validateEmail, showToastError, showSuccessToast } from '../common';


const handleLoginFormSubmit = async ( e ) => { 
   e.preventDefault()

   const loginForm = document.querySelector('#form-login')
   if(!loginForm) return;

   const emailInput = loginForm.querySelector('#email')
   const passwordInput = loginForm.querySelector('#password')

   if(!emailInput || !passwordInput) return;

   const email = emailInput.value ? emailInput.value.trim() : "";
   const password = passwordInput.value ?? "";

   if(!email || !password) return showToastError('Por favor introduce tu email y contraseña');
   if (!validateEmail(email)) return showToastError('Por favor introduce un email válido');

   try {
      
      const { data } = await axios.post('/auth/login', { email, password })

      const { success, redirectUrl, fullName = "" } = data

      if(success && redirectUrl) {
         showSuccessToast(`Bienvenido ${fullName} en unos segundos seras redirigido a inicio`)
         setTimeout(() => {
            window.location.href = redirectUrl
         }, 3000);
         return;
      }

   } catch (error) {

      if( axios.isAxiosError(error) ) {
         const { data } = error.response;
         const { errors = [] } = data;
         if(errors && errors.length > 0) return errors.forEach( showToastError )
      }

      Swal.fire({
         title: 'Error',
         text: 'Ocurrió un error inesperado, por favor recargue la pagina de nuevo, si el problema persiste comunique con el equipo de soporte',
         icon: 'error',
         confirmButtonText: 'Entendido'
      });
      return;
   }

}

export const loginPage = () => {

   const loginForm = document.querySelector('#form-login')
   if ( loginForm ) loginForm.addEventListener('submit', handleLoginFormSubmit)

}
