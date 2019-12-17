<?php

namespace App\GraphQL\Mutation\WMS\GRN;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\GRN\Mutation\Delete as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\GRN;

class Delete extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can('delete', GRN::findorfail($args['id']));
	}
}