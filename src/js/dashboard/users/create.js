import Swal from 'sweetalert2'
import axios from 'axios'

import { validateEmail, validatePhoneNumber, showToastError, isOverEighteen, showSuccessToast } from '../../common';

const handleCreateUserSubmit = async ( e ) => {
   e.preventDefault()

   const createUserForm = document.querySelector('#form-user-create')
   if(!createUserForm) return;

   const nameInput = createUserForm.querySelector('#name')
   const emailInput = createUserForm.querySelector('#email')
   const phoneNumberInput = createUserForm.querySelector('#phoneNumber')
   const birthDateInput = createUserForm.querySelector('#birthDate')
   const passwordInput = createUserForm.querySelector('#password')
   const passwordConfirmInput = createUserForm.querySelector('#passwordConfirm')

   if(!emailInput || !nameInput || !phoneNumberInput || !birthDateInput) return;

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
   
   const submitButton = createUserForm.querySelector('button[type="submit"]');
   submitButton.disabled = true;

   try {
      
      const { data } = await axios.post('/admin/users/create', { email, name, phoneNumber, birthDate, password, passwordConfirm })

      const { success, redirectUrl } = data;

      if(success && redirectUrl) {
         showSuccessToast('Empleado creado con éxito.');
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

   } finally {
      submitButton.disabled = false;
   }

}

export const createUserPage = () => {

   const createUserForm = document.querySelector('#form-user-create')
   if ( createUserForm ) createUserForm.addEventListener('submit', handleCreateUserSubmit)

}
