<?php

namespace App\GraphQL\Query\POS;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\GraphQL\Invoice\Query\Query as Query;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\POS\Invoice as Model;

class Invoice extends Query
{
	public function authorize(array $args) {
        return Auth::user() && Auth::user()->can('view', new Model);
	}
}