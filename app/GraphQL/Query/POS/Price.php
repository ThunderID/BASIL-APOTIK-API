<?php

namespace App\GraphQL\Query\POS;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\Product\Query\Price\Query as Query;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\Price as Model;

class Price extends Query
{
	public function authorize(array $args) {
        return Auth::user() && Auth::user()->can('view', new Model);
	}
}