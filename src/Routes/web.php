<?php

use App\Routes\Router;
use App\Controllers\LoginController;

// Register GET route for displaying login form
Router::get('/login', LoginController::class , 'login');

// Register POST route for processing login form
Router::post('/login', LoginController::class , 'login');

/* Dispatch router */
Router::dispatch();