<?php

use App\Routes\Router;
use App\Controllers\LoginController;
// session_start();

/* Register routes */
// Router::get('/', __DIR__ . '/../app/Controllers/HomeController.php' , 'index');

// echo "<pre>";
// var_dump(Router::$routes);
// echo "</pre>";


Router::get('/login', LoginController::class , 'login');

/* Dispatch router */
Router::dispatch();