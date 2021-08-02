<?php

namespace Larva\ThinkQcs\Events;

use think\Model;

class ModelAttributeTextMasked
{
    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
}
