<?php

namespace app\core;


class Router {

    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct() {

        $this->request = new Request();
        $this->response = new Response();
    }

    public function get($path, $callback) : void {

        $this->routes[Request::GET][$path] = $callback;
    }

    public function post($path, $callback) : void {

        $this->routes[Request::POST][$path] = $callback;
    }
    
    public function resolve() : string {
        
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        $res = null;
        if (!$callback) {
            $this->response->setStatusCode(404);
            $res = $this->renderOnlyView('_404');
        }
        elseif (is_array($callback)) {
            $res = call_user_func($callback, $this->request->method(), $this->request->getBody());
        }

        return $res;
    }

    public function renderView(string $layout, string $view, array $params = []) : string {

        $layoutContent = $this->layoutContent($layout);
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent(string $layout, string $viewContent) : string {

        $layoutContent = $this->layoutContent($layout);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent(string $layout) : string {

        ob_start();
        include_once(Application::$ROOT_DIR . "/views/layouts/$layout.php");
        return ob_get_clean();
    }

    protected function renderOnlyView(string $view, array $params = []) : string {

        /**
         * imports variables into the local symbol table from the params array
         * uses keys as variable names and values as variable values
         */
        extract($params);

        ob_start();
        include_once(Application::$ROOT_DIR . "/views/$view.php");
        return ob_get_clean();
    }
}