<?php

namespace App\GraphQL\Mutation\Accounting\SubsidiaryCOA;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\Accounting\GraphQL\SubsidiaryCOA\Mutation\Delete as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\Accounting\SubsidiaryCOA;

class Delete extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can('delete', SubsidiaryCOA::findorfail($args['id']));
	}
}