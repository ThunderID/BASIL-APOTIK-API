<?php

namespace App\GraphQL\Mutation\POS\POSPoint;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\POSPoint\Mutation\Store as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\POSPoint;

class Store extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? POSPoint::find($args['id']) : app()->make(POSPoint::class)->fill($args)
                                );
	}
}