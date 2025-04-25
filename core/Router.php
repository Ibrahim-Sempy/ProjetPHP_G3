<?php
class Router {
    private $routes = [];

    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        $requestPath = substr($requestUri, strlen($basePath));

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestPath) {
                list($controller, $method) = explode('@', $route['handler']);
                $controllerFile = "../controllers/{$controller}.php";
                
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    $controllerInstance = new $controller();
                    return $controllerInstance->$method();
                }
            }
        }
        
        // Route not found
        header("HTTP/1.0 404 Not Found");
        include '../views/errors/404.php';
    }
}