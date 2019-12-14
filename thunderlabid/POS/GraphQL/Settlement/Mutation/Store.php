<?php

namespace Thunderlabid\POS\GraphQL\Settlement\Mutation;

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
use Thunderlabid\POS\Job\Settlement\Store as JobStore;
/*=====  End of DOMAIN  ======*/

use Thunderlabid\POS\Settlement;

class Store extends Mutation
{
	protected $attributes = [
		'name' => 'Store'
	];

	public function type()
	{
		return GraphQL::type('POSSettlement');
	}

	public function args()
	{
		return [
			'id'     => ['type' => Type::Int()],
			'invoice_id'     => ['type' => Type::int()],
			'no'     => ['type' => Type::String()],
			'date'   => ['type' => Type::String()],
			'type'   => ['type' => Type::String(), 'description' => implode('/', Settlement::getTypes())],
			'ref_no' => ['type' => Type::String()],
			'amount' => ['type' => Type::Float()],
		];
	}

	public function resolve($root, $args)
	{
		return JobStore::dispatchNow(isset($args['id']) ? $args['id'] : null, $args);
	}
}