import { RegularExp } from '../regex'

export const validatePhoneNumber = ( phoneNumber ) => {
   return RegularExp.phoneNumber.test(String(phoneNumber));
}