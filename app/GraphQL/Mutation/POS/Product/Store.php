<?php

namespace App\GraphQL\Mutation\POS\Product;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\Product\Mutation\Store as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\Product;

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