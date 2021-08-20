<?php

namespace app\core;

/**
 * Router: registers callbacks corresponding to specific requests and resolves requests
 */
class Router {

    public Request $request;
    protected array $routes = [];

    public function __construct($request) {

        $this->request = $request;
    }

    public function get($path, $callback) {

        $this->routes['get'][$path] = $callback;
    }
    
    public function resolve() {
        
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            echo 'Not found';
            exit;
        }
        else {
            echo call_user_func($callback);
        }
    }
}