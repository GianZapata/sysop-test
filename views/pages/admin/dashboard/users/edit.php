<input type="hidden" data-user-id="<?php echo $user->id; ?>">

<div class="flex flex-col md:flex-row justify-between">
   <a
      href="/admin/users/create"
      class="text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-medium px-5 py-2.5 me-2 mb-2  focus:outline-none transition duration-300 ease-in-out font-bold uppercase"
   >Crear Nuevo</a>
   <a
      href="/admin/users/show?id=<?php echo $user->id; ?>"
      class="text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-medium px-5 py-2.5 me-2 mb-2  focus:outline-none transition duration-300 ease-in-out font-bold uppercase"
   >Ver Perfil</a>
</div>

<div class="shadow-lg rounded-md bg-white p-4">
   <h2 class="my-2 mx-0 text-3xl text-left font-extrabold text-gray-800">
      Editar Empleado: <?php echo $user->name; ?>
   </h2>
   <p class="text-base text-left my-5">
      En esta sección podrás editar la información del empleado.
   </p>
   <form
      class="space-y-5 my-3"
      id="form-user-edit"
      novalidate
   >
   
      <h3 class="text-xl font-bold text-gray-800 mb-4">
         Información General
      </h3>
      <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-5">
         <div>
            <label           
               class="block mb-2 text-sm font-medium text-gray-900"
               for="name"
            >Nombre completo</label>
            <input 
               type="text"
               class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none border-gray-300"
               placeholder="Tu Nombre"
               name="name"
               required
               id="name"
               value="<?php echo $user->name; ?>"
            >
         </div>
         <div>
            <label           
               class="block mb-2 text-sm font-medium text-gray-900"
               for="email"
            >Correo Electrónico</label>
            <input 
               type="email"
               class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none border-gray-300"
               placeholder="Tu Correo"
               name="email"
               required
               id="email"
               value="<?php echo $user->email; ?>"
            >
         </div>
         <div>
            <label           
               class="block mb-2 text-sm font-medium text-gray-900"
               for="phoneNumber"
            >Numero de teléfono</label>
            <input 
               type="tel"
               class="bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none border-gray-300"
               name="phoneNumber"
               id="phoneNumber"
               pattern="[0-9]{10}"
               required
               title="El número de teléfono debe tener 10 dígitos sin espacios ni guiones"
               placeholder="Tu teléfono"
               value="<?php echo $user->phoneNumber; ?>"
            >
         </div>
         <div>
            <label           
               class="block mb-2 text-sm font-medium text-gray-900"
               for="birthDate"
            >Fecha de nacimiento</label>
            <input 
               type="date"
               class="bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none border-gray-300"
               name="birthDate"
               id="birthDate"
               required
               max="<?php echo $maxBirthDate ?>"
               value="<?php echo $user->birthDate; ?>"
            >
         </div>

      </div>

      <button
         class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-medium px-5 py-2.5 me-2 mb-2  focus:outline-none transition duration-300 ease-in-out font-bold uppercase"
         type="submit"
      >Guardar</button>
   </form>
</div>