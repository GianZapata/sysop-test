import Swal from 'sweetalert2'
import axios from 'axios'

import { validateEmail, validatePhoneNumber, showToastError, isOverEighteen, showSuccessToast } from '../common';

const handleRegisterFormSubmit = async ( e ) => {
   e.preventDefault()

   const registerForm = document.querySelector('#form-register')
   if(!registerForm) return;

   const nameInput = registerForm.querySelector('#name')
   const emailInput = registerForm.querySelector('#email')
   const phoneNumberInput = registerForm.querySelector('#phoneNumber')
   const birthDateInput = registerForm.querySelector('#birthDate')
   const passwordInput = registerForm.querySelector('#password')
   const passwordConfirmInput = registerForm.querySelector('#passwordConfirm')

   if(!emailInput || !passwordInput || !nameInput || !phoneNumberInput || !birthDateInput) return;

   const name = nameInput.value ? nameInput.value.trim() : "";
   const phoneNumber = phoneNumberInput.value ? phoneNumberInput.value.trim() : "";
   const birthDate = birthDateInput.value ? birthDateInput.value.trim() : "";
   const email = emailInput.value ? emailInput.value.trim() : "";
   const password = passwordInput.value ?? "";
   const passwordConfirm = passwordConfirmInput.value ?? "";

   if ( !name ) return showToastError('Por favor introduce tu nombre');

   if ( !validateEmail(email) ) return showToastError('Por favor introduce un email válido');

   if ( !validatePhoneNumber(phoneNumberInput.value) ) return showToastError('El número de teléfono debe tener 10 dígitos');

   if ( !isOverEighteen(birthDate) ) return showToastError('Debes tener al menos 18 años para registrarte.');

   if ( password.length < 6 ) return showToastError('La contraseña debe contener al menos 6 caracteres');

   if ( password !== passwordConfirm ) return showToastError('Las contraseñas no coinciden');
   
   const submitButton = registerForm.querySelector('button[type="submit"]');
   submitButton.disabled = true;

   try {
      
      const { data } = await axios.post('/auth/register', { email, password, name, passwordConfirm, phoneNumber, birthDate })

      const { success, redirectUrl } = data

      if (success && redirectUrl) {
         showSuccessToast('Registro exitoso. Redireccionando...');
         setTimeout(() => {
            window.location.href = redirectUrl;
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
   } finally {
      submitButton.disabled = false;
   }

}

export const registerPage = () => {

   const registerForm = document.querySelector('#form-register')
   if( registerForm ) registerForm.addEventListener('submit', handleRegisterFormSubmit)

}
