<?php

namespace App\GraphQL\Query\WMS;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\GraphQL\StockCard\Query\Query as Query;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\WMS\StockCard as Model;

class StockCard extends Query
{
	public function authorize(array $args) {
        return Auth::user() && Auth::user()->can('view', new Model);
	}
}