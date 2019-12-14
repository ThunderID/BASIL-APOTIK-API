<?php

namespace App\GraphQL\Query\WMS;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\Warehouse\Query\Query as Query;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\Warehouse as Model;

class Warehouse extends Query
{
	public function authorize(array $args) {
        return Auth::user() && Auth::user()->can('view', new Model);
	}
}