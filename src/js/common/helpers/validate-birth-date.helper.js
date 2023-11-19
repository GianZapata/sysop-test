export const isOverEighteen = (birthDateString) => {
   const birthDate = new Date(birthDateString);
   const today = new Date();
   const eighteenYearsAgo = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
   return birthDate <= eighteenYearsAgo;
}