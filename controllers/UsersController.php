<?php

namespace Controllers {

    use Classes\Email;
    use Classes\Helper;
    use Classes\RegExp;
    use Exception;
   use Model\User;
   use MVC\Router;

   class UsersController {


      public static function indexPage( Router $router ){
         if(!isAdmin()) return header('Location: /');
         
         $employees = User::where('admin', false);
         
         return $router->render("pages/admin/dashboard/users/index", [
            "users" => $employees,
            "title" => "Consulta de Empleados"
         ]);
      }

      public static function createPage( Router $router ){
         if(!isAdmin()) return header('Location: /');

         $maxBirthDate = date('Y-m-d', strtotime('-18 years'));
         return $router->render("pages/admin/dashboard/users/create", [
            'title'        => 'Crear Empleado',
            'maxBirthDate' => $maxBirthDate
         ]);
      }
      
      public static function editPage( Router $router ) {
         if(!isAdmin()) return header('Location: /');
         
         $maxBirthDate = date('Y-m-d', strtotime('-18 years'));
         $id = $_GET['id'];
         $id = filter_var($id, FILTER_VALIDATE_INT);
         if(!$id) return header('Location: /admin/users');

         $user = User::find($id);
         if(!$user) return header('Location: /admin/users');

         return $router->render("pages/admin/dashboard/users/edit", [
            'user'         => $user,
            'maxBirthDate' => $maxBirthDate
         ]);

      }

      public static function create() {
         header('Content-Type: application/json');

         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); 
            exit(json_encode([
               'errors' => ['Método no permitido'],
               'success'   => false,
            ]));
         }
         
         if (!isAdmin()) {
            http_response_code(403); 
            exit(json_encode([
               'errors' => ['Acceso denegado'],
               'success'   => false,
            ]));
         }

         $data = json_decode(file_get_contents('php://input'), true);
         $errors = [];
         $user = new User;

         $email = $data['email'] ?? "";
         $name = $data["name"] ?? "";
         $phoneNumber = $data["phoneNumber"] ?? "";
         $birthDate = $data['birthDate'] ?? "";
         $password = $data['password'] ?? "";
         $passwordConfirm = $data['passwordConfirm'] ?? "";

         if (empty($name)) {
            $errors[] = 'El nombre no puede estar vacío';
         }

         if (empty($email)) {
            $errors[] = 'El correo no puede estar vacío';
         } 

         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El formato del correo no es válido';
         } 

         if (empty($phoneNumber)) {
            $errors[] = 'El número de teléfono no puede estar vacío';
         } 
         
         if(!preg_match(RegExp::$phoneNumber, $phoneNumber)) {
            $errors[] = 'El número de teléfono debe tener 10 dígitos';
         }

         if (empty(trim($data['birthDate']))) {
            $errors[] = 'La fecha de nacimiento no puede estar vacía';
         } 
         
         if (!preg_match(RegExp::$birthDate, $birthDate )) {
            $errors[] = 'Fecha de nacimiento no válida';
         } 
         
         if ( !Helper::isOverEighteen( $birthDate ) ) {
            $errors[] = 'Debes tener al menos 18 años de edad.' . $data['birthDate'];
         }

         if( empty($password) || empty($passwordConfirm)) {
            $errors[] = 'La contraseña no puede ir vacía';
         }

         if( strlen($password) < 6 ) {
            $errors[] = 'La contraseña debe contener al menos 6 caracteres';
         }
         
         if( $password !== $passwordConfirm ) {
            $errors[] = 'Las contraseñas son diferentes';
         }

         /** @var \Model\User $existingUser */
         $existingUser = User::whereFirst('email', $email);
         if ($existingUser) {
            $errors[] = 'El correo electrónico ya está registrado';
         }

         if( !empty($errors) ) {
            http_response_code(400);
            exit(json_encode([
               'success'      => false,
               'errors'       => $errors,
            ]));
         }

         $user->synchronize( $data );
         $user->sanitizeEmail();
         $user->hashPassword();

         try {

            $user->save();

            $email = new Email($user->email, $user->name);
            $email->sendWelcomeMessage();

            http_response_code(201);
            exit(json_encode([
               'success'      => true, 
               'errors'       => [],
               'redirectUrl'  => "/admin/users/show?id={$user->id}", 
            ]));
         } catch (Exception $e) {
             http_response_code(500); // Error interno del servidor
            exit(json_encode([
               'success'   => false,
               'errors'    => ['Ocurrió un error inesperado.'],
               'message'   => $e->getMessage(),
            ]));
         }
      }

      public static function update() {
         header('Content-Type: application/json');

         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); 
            exit(json_encode([
               'errors' => ['Método no permitido'],
               'success'   => false,
            ]));
         }
         
         if (!isAdmin()) {
            http_response_code(403); 
            exit(json_encode([
               'errors' => ['Acceso denegado'],
               'success'   => false,
            ]));
         }

         $data = json_decode(file_get_contents('php://input'), true);
         $id = $data['id'] ?? null;
         $id = filter_var($id, FILTER_VALIDATE_INT);

         if (!$id) {
            http_response_code(400);
            exit(json_encode([
               'errors' => ['ID de usuario inválido'],
               'success'   => false,
            ]));
         }

         try {

            /** @var \Model\User $user */
            $user = User::find($id);
            if(!$user) {
               http_response_code(400);
               exit(json_encode([
                  'errors'=> ['Usuario no encontrado'],
                  'success'=> false,
               ]));
            }

            $errors = [];

            if (isset($data['email'])) {
               $email = trim($data['email']);

               if (empty( $email )) {
                  $errors[] = 'El correo no puede estar vacío';
               } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                  $errors[] = 'El formato del correo no es válido';
               } elseif ( $email !== $user->email ) {
                  $existingUser = User::whereFirst('email', $email);
                  if ($existingUser) {
                     $errors[] = 'El correo electrónico ya está en uso por otro usuario';
                  }
               }
            }
            
            if (isset($data['name']) && empty(trim($data['name']))) {
               $errors[] = 'El nombre no puede estar vacío';
            }

            if (isset($data['phoneNumber'])) {
               if (empty(trim($data['phoneNumber']))) {
                  $errors[] = 'El número de teléfono no puede estar vacío';
               } elseif (!preg_match(RegExp::$phoneNumber, $data['phoneNumber'])) {
                  $errors[] = 'El número de teléfono debe tener 10 dígitos';
               }
            }

            if (isset($data['birthDate'])) {
               if (empty(trim($data['birthDate']))) {
                  $errors[] = 'La fecha de nacimiento no puede estar vacía';
               } elseif (!preg_match(RegExp::$birthDate, $data['birthDate'])) {
                  $errors[] = 'Fecha de nacimiento no válida';
               } elseif ( !Helper::isOverEighteen( $data['birthDate']) ) {
                  $errors[] = 'Debes tener al menos 18 años de edad.' . $data['birthDate'];
               }
            }

            if( !empty($errors) ) {
               http_response_code(400);
               exit(json_encode([
                  'success'      => false,
                  'errors'       => $errors,
               ]));
            }

            $user->synchronize([
               'birthDate'    => $data['birthDate']   ?? $user->birthDate,
               'email'        => $data['email']       ?? $user->email,
               'name'         => $data['name']        ?? $user->name,
               'phoneNumber'  => $data['phoneNumber'] ?? $user->phoneNumber
            ]);

            $user->save();

            http_response_code(200); // OK
            exit(json_encode([
               'success'      => true, 
               'errors'       => [],
               'redirectUrl'  => "/admin/users/show?id={$user->id}", 
            ]));
         } catch (Exception $e) {
             http_response_code(500); // Error interno del servidor
            exit(json_encode([
               'success'   => false,
               'errors'    => ['Ocurrió un error inesperado.'],
               'message'   => $e->getMessage(),
            ]));
         }
      }
   
      public static function showPage( Router $router ) {

         if(!isAdmin()) return header('Location: /');
         
         $id = $_GET['id'];
         $id = filter_var($id, FILTER_VALIDATE_INT);
         if(!$id) return header('Location: /admin/users');

         $user = User::find($id);
         if(!$user) return header('Location: /admin/users');

         return $router->render("pages/admin/dashboard/users/show", [
            'user' => $user
         ]);

      }

   }
}