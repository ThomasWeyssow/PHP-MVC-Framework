<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class SiteController extends Controller {

    public function home() {

        $params = [
            'name' => 'Thomas'
        ];
        return $this->render('home', $params);
    }

    public function contact(string $method, array $data) {

        if ($method == Request::GET) {
            return $this->render('contact');
        }
        elseif ($method == Request::POST) {
            echo '<pre>';
            var_dump($data);
            echo '<pre>';
            exit;
            return 'Handling submitted contact data';
        }
    }
}