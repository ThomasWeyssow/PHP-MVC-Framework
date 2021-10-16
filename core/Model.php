<?php

namespace app\core;

abstract class Model {

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';

    public const ERROR_MESSAGES = [
        self::RULE_REQUIRED => 'Required', 
        self::RULE_EMAIL => 'Must be a valid email address', 
        self::RULE_MIN => 'Min {min} characters',
        self::RULE_MAX => 'Max {max} characters', 
        self::RULE_MATCH => 'Must be the same as {match}' 
    ];

    public array $errors = [];

    abstract public function rules() : array;

    public function loadData(array $data) : void {

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function validate() : bool {

        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (is_array($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName == self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName == self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                if ($ruleName == self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName == self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName == self::RULE_MATCH && $value != $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
            }
        }

        return empty($this->errors);
    }

    public function addError(string $attribute, string $rule, $params = []) : void {

        $message = self::ERROR_MESSAGES[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message; // $array[] = 0; -> push 0 in array
    }

    public function hasError($attribute) : bool {
        
        return array_key_exists($attribute, $this->errors);
    }

    public function getFirstError($attribute) : string {

        return $this->errors[$attribute][0] ?? '';
    }

    public function register() {


    }
}