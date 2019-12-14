<?php

namespace App\GraphQL\Query\POS;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\Settlement\Query\Query as Query;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\Settlement as Model;

class Settlement extends Query
{
	public function authorize(array $args) {
        return Auth::user() && Auth::user()->can('view', new Model);
	}
}