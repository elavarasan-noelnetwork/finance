<?php

namespace core;

Route::autoload();
define("APP_ROOT_HOST", Route::routes()['root_host']);
class Route
{

    private static $routes;

    public static function get($route, $callback = [])
    {

        /*       echo "<pre>";
        print_r($route);
        echo "<br>One<br>";
        print_r($callback); */
        //die;


        if (!Route::validate('get', $route)) {
            return;
        }
        Route::call_back($callback);
        exit;
    }

    public static function post($route, $callback = [])
    {
        if (!Route::validate('post', $route)) {
            return;
        }
        Route::call_back($callback);
        exit;
    }

    public static function routes()
    {
        return Route::$routes;
    }

    public static function autoload()
    {


        if (!empty(Route::$routes)) {
            return;
        }


        $route = ['method' => strtolower($_SERVER['REQUEST_METHOD']), 'root_host' => "/", 'full_uri' => "", 'uri' => []];
        $app_dir = str_replace(DIRECTORY_SEPARATOR, "/", array_slice(explode(DIRECTORY_SEPARATOR, APP_DIR), -1)[0]);

        $uri_path = parse_url($_SERVER['REQUEST_URI'])['path'];

        $current_route = trim(str_replace("/" . $app_dir, "", $uri_path));
        $root = trim(trim(str_replace($current_route, "", $uri_path)), "/");
        $root = empty($root) ? "/" : "/{$root}/";

        if ($current_route != "/") {
            $current_route = rtrim(strtolower($current_route), "/");
            $route['uri'] = explode("/", ltrim($current_route, "/"));
        }
        $route['full_uri'] = $current_route;
        $route['root_host'] = $root;
        Route::$routes = $route;

        //print_r(Route::$routes);die;
    }

    private static function call_back($callback)
    {

        // If it's a Closure, call it directly
        if ($callback instanceof \Closure) {
            $callback(Route::$routes);
            return;
        }

        // If it's an array [ControllerClass, method]
        if (is_array($callback) && count($callback) === 2) {
            $controllerClass = $callback[0];
            $method = $callback[1];

            if (!class_exists($controllerClass)) {
                throw new \Exception("Controller class {$controllerClass} does not exist");
            }

            $controller = new $controllerClass();

            if (!method_exists($controller, $method)) {
                throw new \Exception("Method {$method} does not exist in {$controllerClass}");
            }

            // Call the method on the instantiated controller
            $controller->$method(Route::$routes);
            return;
        }
    }

    private static function validate($method, $route)
    {

        if ($method !== Route::$routes['method']) {
            return false;
        }
        if (trim($route) == Route::$routes['full_uri']) {
            return true;
        } else {
            if (strstr($route, '{*}') === false) {
                return false;
            }
            $route = explode("/", trim(strtolower($route), "/"));
            if (count($route) != count(Route::$routes['uri'])) {
                return false;
            }
            foreach ($route as $k => $r) {
                if (!isset(Route::$routes['uri'][$k])) {
                    return false;
                }
                if ($r == Route::$routes['uri'][$k] || $r == "{*}") {
                    continue;
                } else {
                    return false;
                }
            }
            return true;
        }
    }

    public static function notFound($route)
    {

        //echo "aaaa";exit;
        http_response_code(404);
        $page_data = ["app_name" => APP_NAME, "route" => $route];
        View::render(
            "admin/error/404",
            [
                "page_data" => $page_data,
            ]
        );
        exit;
        //include APP_DIR . "/views/errors/404.php"; // Update path as needed
        //exit;
    }
}
