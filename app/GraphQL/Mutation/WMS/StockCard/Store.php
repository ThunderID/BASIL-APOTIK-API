<?php

namespace App\GraphQL\Mutation\WMS\StockCard;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\StockCard\Mutation\Store as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\StockCard;

class Store extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? StockCard::find($args['id']) : app()->make(StockCard::class)->fill($args)
                                );
	}
}