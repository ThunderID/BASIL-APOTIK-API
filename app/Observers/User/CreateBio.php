<?php

namespace App\Observers\User;

use Illuminate\Database\Eloquent\Model;

use App\Bio;

class CreateBio
{
    public function saved(Model $model)
    {
    	if(!$model->bio || ($model->bio->phone != $model->username) || ($model->bio->name != $model->name)){
            $bio    = Bio::where('phone', $model->username)->firstornew(['user_id' => $model->id]);
            $bio->name      = $model->name;
            $bio->phone     = $model->username;
            $bio->user_id   = $model->id;
            $bio->birthdate = '1970-01-01';
            $bio->save();
        }
    }
}
