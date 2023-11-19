<?php 

namespace Controllers {

    use Model\User;
    use MVC\Router;

   class DashboardController {

      public static function dashboardPage( Router $router ){
         if(!isAdmin()) return header('Location: /');

         return $router->render("pages/admin/dashboard/index");
      }


   }

}