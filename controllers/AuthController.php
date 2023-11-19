<?php

namespace Controllers {

   use MVC\Router;
   use Model\User;
   
   use Classes\Email;
   use Classes\Helper;
   use Classes\RegExp;

   class AuthController {

      public static function loginPage( Router $router ) {
         if($_SERVER['REQUEST_METHOD'] !== 'GET') return;

         return $router->render('pages/auth/login', [
            'title' => 'Iniciar Sesión',
         ]);
      }

      public static function login() {
         if($_SERVER['REQUEST_METHOD'] !== 'POST') return;
         header('Content-Type: application/json');
         
         $data = json_decode(file_get_contents('php://input'), true);
         
         $email = $data['email'] ?? "";
         $email = filter_var(strtolower($email), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

         $password = $data['password'] ?? "";

         $errors = [];

         if( empty($email) ) {
            $errors[] = 'El correo del usuario es obligatorio';
         }

         if( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            $errors[] = 'El correo no es valido';
         }

         if( empty($password) ) {
            $errors[] = 'La contraseña no puede ir vacía';
         }

         if( !empty($errors) ) {
            http_response_code(400); 
            exit(json_encode([
               'success'      => false,
               'redirectUrl'  => null,
               'errors'       => ['Credenciales no válidas']
            ]));
         }

         /** @var \Model\User $authUser */
         $authUser = User::whereFirst('email', $email);

         if( !$authUser ) {
            http_response_code(400);
            exit(json_encode([
               'success'      => false,
               'redirectUrl'  => null,
               'errors'       => ['Credenciales incorrectas'],
               'fullName'     => null
            ]));
         }

         if( !password_verify( $password, $authUser->password) ) {
            http_response_code(400);
            exit(json_encode([
               'success'      => false,
               'redirectUrl'  => null,
               'errors'       => ['Credenciales incorrectas'],
               'fullName'     => null
            ]));
         }
         
         $redirectUrl = self::initializeSession($authUser);

         exit(json_encode([
            'success'      => true,
            'redirectUrl'  => $redirectUrl,
            'errors'       => [],
            'fullName'     => $authUser->name
         ]));
      }

      public static function registerPage( Router $router ){
         if($_SERVER['REQUEST_METHOD'] !== 'GET') return;
         
         $maxBirthDate = date('Y-m-d', strtotime('-18 years'));

         return $router->render('pages/auth/register', [
            'title'        => 'Crea tu cuenta en SysOp',
            'maxBirthDate' => $maxBirthDate,
         ]);
      }

      public static function register() {
         if($_SERVER['REQUEST_METHOD'] !== 'POST') return;

         header('Content-Type: application/json');

         $user = new User;
         $errors = [];
         $data = json_decode(file_get_contents('php://input'), true);

         $email = trim($data['email'] ?? "");
         $name = trim($data["name"] ?? "");
         $phoneNumber = trim($data["phoneNumber"] ?? "");
         $birthDate = trim($data['birthDate'] ?? "");
         $password = $data['password'] ?? "";
         $passwordConfirm = $data['passwordConfirm'] ?? "";

         if (empty($name)) {
            $errors[] = 'El nombre no puede estar vacío';
         }

         if( empty($phoneNumber) ) {
            $errors[] = 'El numero de teléfono no puede ir vació';
         }

         if( !preg_match(RegExp::$phoneNumber, $phoneNumber) ) {
            $errors[] = 'El número de teléfono debe tener 10 dígitos';
         }
         
         if( !preg_match(RegExp::$birthDate, $birthDate) ) {
            $errors[] = 'Formato de fecha de nacimiento no válido';
         }

         if( !Helper::isOverEighteen($birthDate) ) {
            $errors[] = 'Debes tener al menos 18 años de edad.';
         }

         if (empty($email)) {
            $errors[] = 'El correo no puede estar vacío';
         } 

         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El formato del correo no es válido';
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
            $errors[] = 'El usuario ya está registrado';
         }

         if( !empty($errors) ) {
            http_response_code(400);
            exit(json_encode([
               'success'      => false,
               'redirectUrl'  => null,
               'errors'       => $errors,
               'fullName'     => null
            ]));
         }

         try {
         
            $user->synchronize([
               'admin'        => 0,
               'birthDate'    => $birthDate,
               'email'        => $email,
               'name'         => $name,
               'password'     => $password,
               'phoneNumber'  => $phoneNumber,
            ]);

            $user->sanitizeEmail();
            $user->hashPassword();
            $user->save();

            $email = new Email($user->email, $user->name);
            $email->sendWelcomeMessage();

            self::initializeSession($user);

            http_response_code(201);
            exit(json_encode([
               'success'      => true,
               'redirectUrl'  => '/', 
               'errors'       => [],
               'fullName'     => $user->name
            ]));
         } catch (\Throwable $th) {
            http_response_code(500);
            exit(json_encode([
               'success'   => false,
               'errors'    => ['Ocurrió un error inesperado.'],
               'message'   => $th->getMessage(),
               'fullName'  => null
            ]));
         }

      }
      public static function logout( Router $router ) {
         $router->logout();
         header('Location: /auth/login');
      }

      private static function initializeSession($user) {
         session_start();
         session_regenerate_id();
         $_SESSION['id'] = $user->id;
         $_SESSION['email'] = $user->email;
         $_SESSION['admin'] = $user->admin ?? null;
         $_SESSION['name'] = $user->name;
         $_SESSION['phoneNumber'] = $user->phoneNumber;
         $_SESSION['birthDate'] = $user->birthDate;
   
         return $user->admin ? '/admin/dashboard' : '/';
      }
   }
}