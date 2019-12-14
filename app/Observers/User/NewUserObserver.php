<?php

namespace App\Observers\User;

use \App\User;
use \App\Jobs\SendSMS;

class NewUserObserver
{
    //
    public function created(User $user)
    {
    	$user->createActivationToken();
    }
}
