<?php

namespace App\GraphQL\Mutation\WMS\Warehouse;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\Warehouse\Mutation\Delete as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\Warehouse;

class Delete extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can('delete', Warehouse::findorfail($args['id']));
	}
}