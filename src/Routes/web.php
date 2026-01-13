<?php

use App\Routes\Router;
// session_start();

/* Register routes */
Router::get('/', __DIR__ . '/../app/Controllers/HomeController.php' , 'index');

echo "<pre>";
var_dump(Router::$routes);
echo "</pre>";