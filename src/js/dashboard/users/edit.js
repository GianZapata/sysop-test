import Swal from 'sweetalert2'
import axios from 'axios'

import { validateEmail, validatePhoneNumber, showToastError, isOverEighteen, showSuccessToast } from '../../common';

const handleEditUserSubmit = async ( e ) => {
   e.preventDefault()

   const editUserForm = document.querySelector('#form-user-edit')
   if(!editUserForm) return;

   const userIdInput = document.querySelector('[data-user-id]');
   const nameInput = editUserForm.querySelector('#name')
   const emailInput = editUserForm.querySelector('#email')
   const phoneNumberInput = editUserForm.querySelector('#phoneNumber')
   const birthDateInput = editUserForm.querySelector('#birthDate')

   if(!userIdInput || !emailInput || !nameInput || !phoneNumberInput || !birthDateInput) return;

   const id = userIdInput.dataset.userId
   const name = nameInput.value ? nameInput.value.trim() : "";
   const phoneNumber = phoneNumberInput.value ? phoneNumberInput.value.trim() : "";
   const birthDate = birthDateInput.value ? birthDateInput.value.trim() : "";
   const email = emailInput.value ? emailInput.value.trim() : "";

   if ( !name ) return showToastError('Por favor introduce tu nombre');

   if ( !validateEmail(email) ) return showToastError('Por favor introduce un email válido');

   if ( !validatePhoneNumber(phoneNumberInput.value) ) return showToastError('El número de teléfono debe tener 10 dígitos');

   if ( !isOverEighteen(birthDate) ) return showToastError('Debes tener al menos 18 años para registrarte.');
   
   const submitButton = editUserForm.querySelector('button[type="submit"]');
   submitButton.disabled = true;

   try {
      
      const { data } = await axios.post('/admin/users/edit', { id, email, name, phoneNumber, birthDate })
      
      const { success, redirectUrl } = data;

      if(success && redirectUrl) {
         showSuccessToast('Empleado actualizado con éxito.');
         setTimeout(() => {
            window.location.href = redirectUrl
         }, 3000);
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

const handleDeleteUser = async ( e ) => {
   e.preventDefault();
   const userIdInput = document.querySelector('[data-user-id]');
   if( !userIdInput ) return;

   const id = userIdInput.dataset.userId
   if( !id ) return;

   console.log({ id });
}

export const editUserPage = () => {

   const editUserForm = document.querySelector('#form-user-edit')
   if ( editUserForm ) editUserForm.addEventListener('submit', handleEditUserSubmit)

   const deleteUserButton = document.querySelector('#delete-user-button')
   if ( deleteUserButton) deleteUserButton.addEventListener('click',handleDeleteUser )
}
