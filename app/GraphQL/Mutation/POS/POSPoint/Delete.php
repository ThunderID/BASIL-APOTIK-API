<?php

namespace App\GraphQL\Mutation\POS\POSPoint;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\POSPoint\Mutation\Delete as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\POSPoint;

class Delete extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can('delete', POSPoint::findorfail($args['id']));
	}
}