<?php

namespace app\core\form;
use app\core\Model;

class Field {

    public Model $model;
    public string $attribute;
    public string $label;
    public string $type;

    public function __construct(Model $model, string $attribute, string $label, $type) {

        $this->model = $model;
        $this->attribute = $attribute;
        $this->label = $label;
        $this->type = $type;
    }

    public function __toString() {

        $validity = $this->model->hasError($this->attribute) ? 'is-invalid' : '';

        return "
            <div class='mb-3'>
                <label class='form-label'>{$this->label}</label>
                <input 
                    type='{$this->type}' 
                    name='{$this->attribute}' 
                    value='{$this->model->{$this->attribute}}' 
                    class='form-control {$validity}'
                >
                <div class='invalid-feedback'>
                    {$this->model->getFirstError($this->attribute)}
                </div>
            </div>
        ";
    }
}