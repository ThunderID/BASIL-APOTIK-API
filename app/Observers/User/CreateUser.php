<?php

namespace App\Observers\User;

use Illuminate\Database\Eloquent\Model;

use App\User;

class CreateUser
{
    public function saving(Model $model)
    {
    	if(is_null($model->user_id)){
            $user   = User::create(['name' => $model->name, 'username' => $model->phone, 'password' => (string)rand(10000000, 99999999)]);
            $model->user_id     = $user->id;
        }elseif(!str_is($model->user->name, $model->name)){
        	$model->user->name 	= $model->name;
        	$model->user->save();
        }
    }
}
