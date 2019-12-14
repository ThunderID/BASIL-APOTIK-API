<?php

namespace App\GraphQL\Mutation\POS\Invoice;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\Invoice\Mutation\Store as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\Invoice;

class Store extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Invoice::find($args['id']) : app()->make(Invoice::class)->fill($args)
                                );
	}
}