<?php

namespace App\GraphQL\Mutation\WMS\GDN;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\GDN\Mutation\Store as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\GDN;

class Store extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? GDN::find($args['id']) : app()->make(GDN::class)->fill($args)
                                );
	}
}