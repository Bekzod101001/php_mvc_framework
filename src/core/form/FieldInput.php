<?php

namespace app\core\form;

use app\core\enums\FieldInputTypeEnum;

class FieldInput extends Field
{
    public string $type;
    public function __construct($model, string $attribute, string $label = '', string $type = 'text')
    {
        parent::__construct($model, $attribute, $label);
        $this->type = $type;
    }

    public function render()
    {
        return sprintf('
            <input
              name="%s"
              type="%s"
              value="%s"
              class="form-control %s"
              placeholder="Enter Name"
            />',
            $this->attribute,
            $this->type,
            $this->model->{$this->attribute},
            $this->modelHasError ? 'is-invalid' : ''
        );
    }


}