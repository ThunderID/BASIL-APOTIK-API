<?php

namespace App\GraphQL\Query\Accounting;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\Accounting\GraphQL\SubsidiaryCOA\Query\Query as Query;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\Accounting\SubsidiaryCOA as Model;

class SubsidiaryCOA extends Query
{
	public function authorize(array $args) {
        return Auth::user() && Auth::user()->can('view', new Model);
	}
}