<?php

namespace app\core\form;

use app\core\Model;

abstract class Field
{
    public Model $model;
    public string $label;
    public string $attribute;
    public string $modelFirstError;
    public bool $modelHasError;

    /**
     * @param  Model  $model
     * @param  string  $attribute
     */
    public function __construct(Model $model, string $attribute, string $label = '')
    {
        $this->label = $label;
        $this->model = $model;
        $this->attribute = $attribute;

        $this->modelHasError = $this->model->hasError($this->attribute);
        $this->modelFirstError = $this->modelHasError ? $this->model->getFirstError($this->attribute) : "";
    }

    public function __toString()
    {
        return sprintf('
            <div class="form-group">
                <label>%s</label>
                %s
                <div class="invalid-feedback">
                  %s
                </div>
            </div>',
            $this->label ?? $this->attribute,
            $this->render(),
            $this->modelFirstError
        );
    }

    abstract public function render();

}