<?php

namespace App\GraphQL\Query\POS;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\POSPoint\Query\Query as Query;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\POSPoint as Model;

class POSPoint extends Query
{
	public function authorize(array $args) {
		return true;
        // return Auth::user() && Auth::user()->can('view', new Model);
	}
}