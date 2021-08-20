<?php

namespace app\core;

/**
 * Router: registers callbacks corresponding to specific requests and resolves requests
 */
class Router {

    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response) {

        $this->response = $response;
        $this->request = $request;
    }

    public function get($path, $callback) {

        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback) {

        $this->routes['post'][$path] = $callback;
    }
    
    public function resolve() {
        
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        $res = null;
        if (!$callback) {
            $this->response->setStatusCode(404);
            $res = $this->renderView('_404');
        }
        elseif (is_string($callback)) {
            $res = $this->renderView($callback);
        }
        else {
            $res = call_user_func($callback);
        }

        return $res;
    }

    public function renderView(string $view) {

        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent(string $viewContent) {

        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent() {

        ob_start();
        include_once(Application::$ROOT_DIR . "/views/layouts/main.php");
        return ob_get_clean();
    }

    protected function renderOnlyView(string $view) {

        ob_start();
        include_once(Application::$ROOT_DIR . "/views/$view.php");
        return ob_get_clean();
    }
}