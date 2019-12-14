<?php

namespace App\GraphQL\Mutation\POS\Product\Price;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\Product\Mutation\Price\Delete as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\Price;

class Delete extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can('delete', Price::findorfail($args['id']));
	}
}