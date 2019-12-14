<?php

namespace App\Observers\User;

use \App\User;

class PasswordObserver
{
    //
    public function creating(User $user)
    {
    	$user->encryptPassword();
    }

    public function updating(User $user)
    {
    	$user->encryptPassword();
    }
}
