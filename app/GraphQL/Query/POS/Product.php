<?php

namespace App\GraphQL\Query\POS;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\Product\Query\Query as Query;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\Product as Model;

class Product extends Query
{
	public function authorize(array $args) {
        return Auth::user() && Auth::user()->can('view', new Model);
	}
}