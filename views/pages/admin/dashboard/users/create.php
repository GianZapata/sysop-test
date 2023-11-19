<div class="flex flex-col md:flex-row justify-end">
   <a
      href="/admin/users"
      class="text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-medium px-5 py-2.5 me-2 mb-2  focus:outline-none transition duration-300 ease-in-out font-bold uppercase"
   >Listado</a>
</div>

<div class="shadow-lg rounded-md bg-white p-4">
   <h2 class="my-2 mx-0 text-3xl text-left font-extrabold text-gray-800">
      Agregar Nuevo Empleado
   </h2>
   <p class="text-base text-left my-5">
      Ingresa los datos del empleado.
   </p>
   <form
      class="space-y-5 my-3"
      id="form-user-create"
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
            >
         </div>

         <div>
            <label           
               class="block mb-2 text-sm font-medium text-gray-900"
               for="password"
            >Contraseña</label>
            <input 
               type="password"
               class="bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none border-gray-300"
               placeholder="Tu Contraseña"
               name="password"
               id="password"
               required
            >
         </div>
         <div>
            <label           
               class="block mb-2 text-sm font-medium text-gray-900"
               for="passwordConfirm"
            >Confirmar Contraseña</label>
            <input 
               type="password"
               class="bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none border-gray-300"
               placeholder="Tu Contraseña"
               name="passwordConfirm"
               id="passwordConfirm"
               required
            >
         </div>
      </div>

      <button
         class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-medium px-5 py-2.5 me-2 mb-2  focus:outline-none transition duration-300 ease-in-out font-bold uppercase"
         type="submit"
      >Crear Empleado</button>
   </form>
</div>