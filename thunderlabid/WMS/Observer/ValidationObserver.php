<?php

namespace Thunderlabid\WMS\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Illuminate\Database\Eloquent\Model;
use Validator;

class ValidationObserver
{
	public function creating(Model $model)
    {
    	if (method_exists($model, 'getRules'))
    	{
    		Validator::make($model->makeVisible($model->getHidden())->toArray(), $model->getRules())->validate();
    	}
    }

    public function updating(Model $model)
    {
    	if (method_exists($model, 'getRules'))
    	{
    		Validator::make($model->makeVisible($model->getHidden())->toArray(), $model->getRules())->validate();
    	}
    }
}
