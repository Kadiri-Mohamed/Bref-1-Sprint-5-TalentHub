<?php

use App\Routes\Router;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\LogoutController;

// login 
Router::get('/login', LoginController::class , 'index');
Router::post('/login', LoginController::class , 'login');

// register
Router::get('/register', RegisterController::class , 'index');
Router::post('/register', RegisterController::class , 'register');

// logout
Router::get('/logout', LogoutController::class , 'logout');

/* Dispatch router */
Router::dispatch();