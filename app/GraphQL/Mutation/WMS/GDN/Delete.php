<?php

namespace App\GraphQL\Mutation\WMS\GDN;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\GDN\Mutation\Delete as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\GDN;

class Delete extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can('delete', GDN::findorfail($args['id']));
	}
}