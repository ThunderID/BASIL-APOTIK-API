<?php

namespace Thunderlabid\POS\GraphQL\Invoice\Mutation;

/*===============================
=            LARAVEL            =
===============================*/
use DB;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Arr;
use App\Libraries\Helper;
/*=====  End of LARAVEL  ======*/

/*===============================
=            GraphQL            =
===============================*/
use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Error\Error;
use Rebing\GraphQL\Support\Mutation;
/*=====  End of GraphQL  ======*/

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\Job\Invoice\Store as JobStore;
/*=====  End of DOMAIN  ======*/


class Store extends Mutation
{
	protected $attributes = [
		'name' => 'Store'
	];

	public function type()
	{
		return GraphQL::type('POSInvoice');
	}

	public function args()
	{
		return [
			'id'       => ['type' => Type::Int()],
			'no'       => ['type' => Type::String()],
			'date'     => ['type' => Type::String()],
			'customer' => ['type' => Type::String()],
			'discount' => ['type' => Type::Float()],
			'tax'      => ['type' => Type::Float()],
			'lines'    => ['type' => Type::ListOf(GraphQL::type("POSIInvoiceLine"))],
			'pos_point_id' 	=> ['type' => Type::int()],
		];
	}

	public function resolve($root, $args)
	{
		return JobStore::dispatchNow(isset($args['id']) ? $args['id'] : null, $args);
	}
}