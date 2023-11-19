
<div class="flex flex-col md:items-center md:flex-row md:justify-between">
   <h2 class="my-2 mx-0 text-3xl text-left font-extrabold">
      <?php echo $user->name; ?>
   </h2>

   <div class="flex flex-col md:flex-row">
      <a href="/admin/users/edit?id=<?php echo $user->id; ?>" class=" text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-medium px-5 py-2.5 me-2 mb-2  focus:outline-none transition duration-300 ease-in-out font-bold uppercase">Editar</a>
      <a href="/admin/users" class=" text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-medium px-5 py-2.5 me-2 mb-2  focus:outline-none transition duration-300 ease-in-out font-bold uppercase">Listado</a>

   </div>

</div>

<div class="md:flex gap-5 my-5">
   <div class="w-full md:w-2/3 shadow-lg rounded-2xl p-4 bg-white">
      <h3 class="text-2xl text-gray-800 font-bold text-left">
         Información del Usuario
      </h3>
      <div class="flex flex-col md:flex-row justify-between items-center mt-5">
         <div class="flex flex-col md:flex-row items-center justify-center md:justify-start gap-3">
            <div class="md:flex flex-col items-center md:items-start justify-center">
               <picture>
                  <source srcset="/build/img/default-profile.webp" type="image/webp">
                  <source srcset="/build/img/default-profile.png" type="image/png">
                  <img class="rounded-lg w-48 h-48" loading="lazy" width="200" height="300" src="/build/img/default-profile.png" alt="Foto de perfil">
               </picture>
            </div>

            <div class="flex flex-col items-center md:items-start justify-center">
               <?php if( $user->email ): ?>
                  <p class="text-lg text-gray-800 text-left">
                     Email:
                     <span class="font-bold text-lg text-gray-800">
                        <?php echo $user->email; ?>
                     </span>
                  </p>
               <?php endif; ?>

               <?php if( $user->phoneNumber ): ?>
                  <p class="text-lg text-gray-800 text-left">
                     Teléfono:
                     <span class="font-bold text-lg text-gray-800">
                        <?php echo $user->phoneNumber; ?>
                     </span>
                  </p>
               <?php endif; ?>

               <?php if( $user->birthDate ): ?>
                  <p class="text-lg text-gray-800 text-left">
                     Fecha de nacimiento:
                     <span class="font-bold text-lg text-gray-800">
                        <?php echo Classes\Helper::formatSpanishShortDate($user->birthDate); ?>
                     </span>
                  </p>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</div>
