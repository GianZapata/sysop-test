<?php

namespace Controllers {

   use MVC\Router;

   class HomeController {

      public static function homePage( Router $router ) {

         if (!isAuth()) return header('Location: /auth/login');

         return $router->render("pages/home/index", [
            "title" => "Inicio"
         ]);
      }

      public static function notFoundPage( Router $router ) {
         $router->render("pages/shared/not-found", [
            "title" => "Pagina no encontrada"
         ]);
      }
   }

}