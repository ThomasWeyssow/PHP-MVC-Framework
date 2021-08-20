<?php

namespace app\core;

class Request {

    public function __construct() {
        
    }

    public function getPath() {

        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // Question mark in the url
        $position = strpos($path, '?');
        if ($position) {
            $path = substr($path, 0, $position);
        }

        return $path;
    }

    public function getMethod() {

        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}