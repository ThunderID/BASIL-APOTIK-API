<?php

namespace App\GraphQL\Query\WMS;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\GRN\Query\Query as Query;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\GRN as Model;

class GRN extends Query
{
	public function authorize(array $args) {
        return Auth::user() && Auth::user()->can('view', new Model);
	}
}