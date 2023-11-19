<div class="mx-auto w-[min(95%,650px)] mt-28">

   <h1 class="text-blue-700 font-semibold text-6xl text-center">SysOp</h1>

   <div class="py-8 px-4">
   
      <h2 class="my-2 mx-0 text-3xl text-center font-black text-gray-800"><?php echo $title; ?></h2>
      
      <p class="text-base text-center mb-5">
         Ingresa tu correo electrónico y contraseña para iniciar sesión
      </p>

      <form class="flex flex-col space-y-5" method="POST" id="form-login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
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
               id="email"
               required
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
         <button
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-medium px-5 py-2.5 me-2 mb-2  focus:outline-none transition duration-300 ease-in-out font-bold uppercase"
            type="submit"
         >Iniciar Sesión</button>
      </form>

      <div class="mt-5 flex flex-col items-center gap-3 md:flex-row md:justify-between">
         <p class="text-sm font-medium text-gray-500">
            ¿No tienes una cuenta?
            <a href="/auth/register" class="font-medium text-blue-500 hover:underline hover:text-blue-600 transition duration-300 ease-in-out">
               Crea una
            </a>
         </p>
      </div>
   </div>
   
</div>