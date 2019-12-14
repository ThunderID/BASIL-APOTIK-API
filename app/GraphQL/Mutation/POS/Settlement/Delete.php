<?php

namespace App\GraphQL\Mutation\POS\Settlement;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\Settlement\Mutation\Delete as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\Settlement;

class Delete extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can('delete', Settlement::findorfail($args['id']));
	}
}