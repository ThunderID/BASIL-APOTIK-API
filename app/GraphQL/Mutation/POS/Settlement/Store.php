<?php

namespace App\GraphQL\Mutation\POS\Settlement;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\Settlement\Mutation\Store as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\Settlement;

class Store extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Settlement::find($args['id']) : app()->make(Settlement::class)->fill($args)
                                );
	}
}