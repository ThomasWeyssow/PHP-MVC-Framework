<?php

namespace app\core;
use app\controllers\SiteController;
use app\controllers\AuthController;

class Application {

    public static string $ROOT_DIR;

    public Router $router;

    public SiteController $siteController;
    public AuthController $authController;

    public function __construct(string $rootPath) {

        self::$ROOT_DIR = $rootPath;
        
        $this->router = new Router();

        $this->siteController = new SiteController($this->router);
        $this->authController = new AuthController($this->router);

        $this->router->get('/', [$this->siteController, 'home']);

        $this->router->get('/contact', [$this->siteController, 'contact']);
        $this->router->post('/contact', [$this->siteController, 'handleContact']);

        $this->router->get('/login', [$this->authController, 'login']);
        $this->router->post('/login', [$this->authController, 'login']);
        $this->router->get('/register', [$this->authController, 'register']);
        $this->router->post('/register', [$this->authController, 'register']);
    }

    public function run() : void {

        echo $this->router->resolve();
    }
}