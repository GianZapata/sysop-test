import Swal from 'sweetalert2'

const Toast = Swal.mixin({
   toast: true,
   position: "top-end",
   showConfirmButton: false,
   timer: 3000,
   timerProgressBar: true,
   didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
   }
});

const showToast = ( message = '', icon, options = {}) => {
   if (!message) return;
   Toast.fire({
      title: message,
      icon: icon,
      ...options,
   });
};

export const showToastError = (message) => {
   showToast(message, 'error');
};

export const showSuccessToast = (message) => {
   showToast(message, 'success');
};