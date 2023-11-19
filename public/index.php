<?php

use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\HomeController;
use Controllers\UsersController;
use MVC\Router;

require_once __DIR__ . '/../includes/app.php';

$router = new Router();

$router->get('/', [HomeController::class,'homePage']);

$router->get('/auth/login', [AuthController::class, 'loginPage']);
$router->post('/auth/login', [AuthController::class, 'login']);

$router->get('/auth/register', [AuthController::class, 'registerPage']);
$router->post('/auth/register', [AuthController::class, 'register']);

$router->get('/auth/logout',[AuthController::class,'logout']);
$router->post('/auth/logout',[AuthController::class,'logout']);

$router->get('/admin/dashboard', [DashboardController::class, 'dashboardPage']);

/** Users */
$router->get('/admin/users', [UsersController::class, 'indexPage']);

$router->get('/admin/users/create', [UsersController::class, 'createPage']);
$router->post('/admin/users/create', [UsersController::class, 'create']);

$router->get('/admin/users/edit', [UsersController::class, 'editPage']);
$router->post('/admin/users/edit', [UsersController::class, 'update']);

$router->get('/admin/users/show', [UsersController::class, 'showPage']);

$router->get('/404', [HomeController::class, 'notFoundPage']);

$router->checkRoutes();
