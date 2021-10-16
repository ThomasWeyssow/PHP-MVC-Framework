<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Router;
use app\models\RegisterModel;

class AuthController extends Controller {

    public function __construct(Router $router) {

        parent::__construct($router);
        $this->setLayout('auth');
    }

    public function login(string $method, array $data) : string {

        if ($method == Request::GET) {
            return $this->render('login');
        }
        elseif ($method == Request::POST) {
            echo '<pre>';
            var_dump($data);
            echo '<pre>';
            exit;
            return 'Handling submitted login data';
        }
        
    }

    public function register(string $method, array $data) : string {

        $registerModel = new RegisterModel();

        if ($method == Request::POST) {
            $registerModel->loadData($data);
            if ($registerModel->validate() && $registerModel->register()) {
                return 'success';
            }
        }

        return $this->render('register', [
            'model' => $registerModel
        ]);
    }
}