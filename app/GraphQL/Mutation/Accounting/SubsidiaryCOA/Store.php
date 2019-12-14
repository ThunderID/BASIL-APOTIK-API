<?php

namespace App\GraphQL\Mutation\Accounting\SubsidiaryCOA;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\Accounting\GraphQL\SubsidiaryCOA\Mutation\Store as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\Accounting\SubsidiaryCOA;

class Store extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? SubsidiaryCOA::find($args['id']) : app()->make(SubsidiaryCOA::class)->fill($args)
                                );
	}
}