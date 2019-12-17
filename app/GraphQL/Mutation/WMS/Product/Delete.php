<?php

namespace App\GraphQL\Mutation\WMS\Product;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\Product\Mutation\Delete as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\Product;

class Delete extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can('delete', Product::findorfail($args['id']));
	}
}