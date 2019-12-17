<?php

namespace App\GraphQL\Mutation\WMS\Warehouse;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\Warehouse\Mutation\Store as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\Warehouse;

class Store extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Warehouse::find($args['id']) : app()->make(Warehouse::class)->fill($args)
                                );
	}
}