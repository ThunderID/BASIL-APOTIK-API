<?php

namespace App\Observers\User;

use \App\UserToken;
use \App\Jobs\SendSMS;

class UserTokenCreatedObserver
{
    //
    public function created(UserToken $user_token)
    {
    	switch ($user_token->type) {
    		case UserToken::RESET_PASSWORD:
		    	$text = "Hi, untuk mereset password anda silakan masukkan OTP (One-Time-Password) ini " . $user_token->token;
    			break;

    		case UserToken::ACTIVATION:
		    	$text = "Hi, untuk mengaktifkan akun anda silakan masukkan OTP (One-Time-Password) ini " . $user_token->token;
    			break;
    	}

    	SendSMS::dispatch($user_token->user->username, $text);
    }
}
