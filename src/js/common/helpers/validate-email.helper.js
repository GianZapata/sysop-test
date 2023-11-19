import { RegularExp } from '../regex'

export const validateEmail = ( email ) => {
   return RegularExp.email.test(String(email).toLowerCase());
}