<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

use Validator;

class ProductObserver
{
    public function updating(Model $model)
    {
        if($model->ha)
    }
}
