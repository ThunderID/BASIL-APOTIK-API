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
use Thunderlabid\POS\Job\Product\Price\Delete as JobStore;
/*=====  End of DOMAIN  ======*/


class Delete extends Mutation
{
	protected $attributes = [
		'name' => 'Delete'
	];

	public function type()
	{
		return GraphQL::type('POSPrice');
	}

	public function args()
	{
		return [
			'product_id' => ['type' => Type::Int(), 'rules' => 'required'],
			'price_id'   => ['type' => Type::Int(), 'rules' => 'required'],
		];
	}

	public function resolve($root, $args)
	{
		return JobStore::dispatchNow($args['product_id'], $args['price_id']);
	}
}