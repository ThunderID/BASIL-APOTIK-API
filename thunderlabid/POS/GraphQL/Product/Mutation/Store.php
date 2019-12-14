<?php

namespace Thunderlabid\POS\GraphQL\Product\Mutation;

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
use Thunderlabid\POS\Job\Product\Store as JobStore;
/*=====  End of DOMAIN  ======*/


class Store extends Mutation
{
	protected $attributes = [
		'name' => 'Store'
	];

	public function type()
	{
		return GraphQL::type('POSProduct');
	}

	public function args()
	{
		return [
			'id'           => ['type' => Type::Int()],
			'pos_point_id' => ['type' => Type::Int()],
			'code'         => ['type' => Type::String()],
			'group'        => ['type' => Type::String()],
			'name'         => ['type' => Type::String()],
			'description'  => ['type' => Type::String()],
			'is_available' => ['type' => Type::Boolean()],
		];
	}

	public function resolve($root, $args)
	{
		return JobStore::dispatchNow(isset($args['id']) ? $args['id'] : null, $args);
	}
}