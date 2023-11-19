<div class="flex flex-col md:flex-row md:justify-between">
   <h2 class="text-3xl text-left font-extrabold text-gray-800">
      Consulta de Empleados
   </h2>
   <a href="/admin/users/create"  class="text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-medium px-5 py-2.5 me-2 mb-2  focus:outline-none transition duration-300 ease-in-out font-bold uppercase">Crear Empleado</a>
</div>

<div class="lg:w-1/3 my-5 flex items-center">
   <label class="sr-only" for="search-client">
      Buscar Empleados
   </label>
   <div class="relative w-full">
      <div class="hidden absolute inset-y-0 left-0 md:flex items-center pl-3 pointer-events-none">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
         </svg>
      </div>
      <input
         type="search"
         class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full md:pl-10 p-2.5 outline-none"
         placeholder="Buscar Clientes..."
         name="search-client"
      />
   </div>
</div>
<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
   <table class="table-auto w-full border-collapse divide-y divide-gray-200">
         <thead class="bg-white">
            <tr>
               <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2 md:w-auto"
               >
                  ID
               </th>

               <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2 md:w-auto"
               >
                  Nombre
               </th>
               <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell"
               >
                  Correo
               </th>
               <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell"
               >
                  Teléfono
               </th>
               <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell"
               >
                  Fecha de Nacimiento
               </th>
               <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2 md:w-auto"
               ></th>
            </tr>
         </thead>
            <tbody class="bg-white divide-y divide-gray-200">
               <?php foreach( $users as $user ) : ?>
                  <tr class="odd:bg-white even:bg-gray-50 border-b">
                     <td class="px-6 py-4 text-slate-800 text-sm">
                        <?php echo $user->id; ?>
                     </td>
                     <td class="px-6 py-4 text-slate-800 text-sm">
                        <?php echo $user->name; ?>
                     </td>
                     <td class="px-6 py-4 text-slate-800 text-sm hidden md:table-cell">
                        <?php echo $user->email; ?>
                     </td>
                     <td class="px-6 py-4 text-slate-800 text-sm hidden md:table-cell">
                        <?php echo $user->phoneNumber; ?>
                     </td>
                     <td class="px-6 py-4 text-slate-800 text-sm hidden md:table-cell">
                        <?php echo Classes\Helper::formatSpanishShortDate($user->birthDate); ?>
                     </td>
                     <td class="px-6 py-4 text-slate-800 text-sm text-center">
                        <a
                           href="/admin/users/show?id=<?php echo $user->id; ?>"
                           class="block w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-medium px-5 py-2.5 me-2 mb-2  focus:outline-none transition duration-300 ease-in-out font-bold uppercase"
                        >
                           Ver Perfil
                        </a>
                     </td>
                  </tr>
               <?php endforeach; ?>

               <?php foreach (["","",""] as $key) : ?>
               <tr class="odd:bg-white  even:bg-gray-50 border-b">
                  <td class="px-6 py-4 whitespace-nowrap">
                     <div class="h-4 bg-gray-200 rounded w-1/4 animate-pulse"></div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                     <div class="h-4 bg-gray-200 rounded w-3/4 animate-pulse"></div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                     <div class="h-4 bg-gray-200 rounded w-3/4 animate-pulse"></div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                     <div class="h-4 bg-gray-200 rounded w-full animate-pulse"></div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                     <div class="h-4 bg-gray-200 rounded w-full animate-pulse"></div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                     <div class="h-4 bg-gray-200 rounded w-full animate-pulse"></div>
                  </td>
               </tr>
               <?php endforeach; ?>
         </tbody>
   </table>
</div>