<?php

namespace App\GraphQL\Mutation\WMS\StockCard;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\StockCard\Mutation\Delete as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\StockCard;

class Delete extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can('delete', StockCard::findorfail($args['id']));
	}
}