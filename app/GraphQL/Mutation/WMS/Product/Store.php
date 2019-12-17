<?php

namespace App\GraphQL\Mutation\WMS\Product;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\Product\Mutation\Store as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\Product;

class Store extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Product::find($args['id']) : app()->make(Product::class)->fill($args)
                                );
	}
}