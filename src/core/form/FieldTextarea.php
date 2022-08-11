<?php

namespace app\core\form;

use app\core\enums\FieldInputTypeEnum;

class FieldTextarea extends Field
{
    public function __construct($model, string $attribute, string $label = '')
    {
        parent::__construct($model, $attribute, $label);
    }

    public function render()
    {
        return sprintf('
            <textarea
              name="%s"
              class="form-control %s"
              placeholder="Enter Name"
            >%s</textarea>',
            $this->attribute,
            $this->modelHasError ? 'is-invalid' : '',
            $this->model->{$this->attribute}
        );
    }

}