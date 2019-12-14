<?php

namespace App\GraphQL\Mutation\POS\Invoice;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\Invoice\Mutation\Delete as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\Invoice;

class Delete extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can('delete', Invoice::findorfail($args['id']));
	}
}