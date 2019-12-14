<?php

namespace Thunderlabid\POS\GraphQL\Product\Mutation\Price;

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
use Thunderlabid\POS\Job\Product\Price\Add as JobStore;
/*=====  End of DOMAIN  ======*/


class Add extends Mutation
{
	protected $attributes = [
		'name' => 'Add'
	];

	public function type()
	{
		return GraphQL::type('POSPrice');
	}

	public function args()
	{
		return [
			'product_id' => ['type' => Type::Int()],
			'active_at'  => ['type' => Type::String()],
			'price'      => ['type' => Type::float()],
			'discount'   => ['type' => Type::float()],
		];
	}

	public function resolve($root, $args)
	{
		return JobStore::dispatchNow(isset($args['product_id']) ? $args['product_id'] : null, $args);
	}
}