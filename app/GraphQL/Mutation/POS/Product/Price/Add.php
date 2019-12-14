<?php

namespace App\GraphQL\Mutation\POS\Product\Price;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\Product\Mutation\Price\Add as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\Price;

class Add extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Price::find($args['id']) : app()->make(Price::class)->fill($args)
                                );
	}
}