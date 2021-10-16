<?php

namespace app\core;

class Request {

    public const GET = 'get';
    public const POST = 'post';

    public function __construct() {
        
    }

    public function getPath() {

        $path = $_SERVER['REQUEST_URI'] ?? '/';

        $position = strpos($path, '?');
        if ($position) {
            $path = substr($path, 0, $position);
        }

        return $path;
    }

    public function method() {

        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody() {

        $body = [];

        if ($this->method() == self::GET) {

            foreach ($_GET as $key => $value) {

                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() == self::POST) {

            foreach ($_POST as $key => $value) {

                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}