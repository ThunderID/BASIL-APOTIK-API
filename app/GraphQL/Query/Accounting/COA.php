<?php

namespace App\GraphQL\Query\Accounting;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\Accounting\GraphQL\COA\Query\Query as Query;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\Accounting\COA as Model;

class COA extends Query
{
	public function authorize(array $args) {
        return Auth::user() && Auth::user()->can('view', new Model);
	}
}