<?php

namespace app\core;


class Controller {

    public string $layout = 'main';
    public Router $router;

    public function __construct(Router $router) {
        
        $this->router = $router;
    }

    public function setLayout(string $layout) {

        $this->layout = $layout;
    }

    protected function render(string $view, array $params = []) : string {

        return $this->router->renderView($this->layout, $view, $params);
    }
}