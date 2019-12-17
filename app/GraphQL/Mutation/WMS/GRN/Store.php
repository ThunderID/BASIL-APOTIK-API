<?php

namespace App\GraphQL\Mutation\WMS\GRN;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\GRN\Mutation\Store as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\GRN;

class Store extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? GRN::find($args['id']) : app()->make(GRN::class)->fill($args)
                                );
	}
}