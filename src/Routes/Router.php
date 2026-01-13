<?php

namespace App\Routes;
class Router
{
    public static $routes = [];

    private static function addRoute($route, $controller, $action, $method)
    {

        self::$routes[$method][$route] = [
            'controller' => $controller,
            'action' => $action

        ];
    }

    public static function get($route, $controller, $action)
    {
        self::addRoute($route, $controller, $action, "GET");

    }
    public static function post($route, $controller, $action)
    {
        self::addRoute($route, $controller, $action, "POST");

    }
    public static function put($route, $controller, $action)
    {
        self::addRoute($route, $controller, $action, "PUT");

    }

    public static function dispatch()
    {
        $path = strtok($_SERVER['REQUEST_URI'], "?");
        $method = $_SERVER['REQUEST_METHOD'];
        
        // echo "{$_SERVER['REQUEST_URI']}<br>";
        // echo "$uri<br>";
        
        $path = str_replace("/soso", "", $path);




        if ($path === '')
            $path = '/';
        // echo $uri."<br>";
        if (array_key_exists($path, self::routes[$method])) {
            $controller = self::$routes[$method][$path]['controller'];
            $action = self::$routes[$method][$path]['action'];


            $controller = new $controller();
            $controller->$action();

        } else {
            http_response_code(404);
            echo ("404 fin awa 4di");
        }
    }




}