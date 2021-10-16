<?php

namespace app\core\form;
use app\core\Model;

class Form {

    public static function begin(string $action, string $method) : void {

        echo "<form action='{$action}' method='{$method}'>";
    }

    public static function end() : void {

        echo '</form>';
    }

    public static function field(Model $model, $attribute, $label, $type) : void {

        echo new Field($model, $attribute, $label, $type);
    }
    
}