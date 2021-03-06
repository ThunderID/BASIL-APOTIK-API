<?php

namespace Thunderlabid\POS\GraphQL\POSPoint\Mutation;

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
use Thunderlabid\POS\Job\POSPoint\Store as JobStore;
/*=====  End of DOMAIN  ======*/


class Store extends Mutation
{
	protected $attributes = [
		'name' => 'Store'
	];

	public function type()
	{
		return GraphQL::type('POSPoint');
	}

	public function args()
	{
		return [
			'id'        => ['type'	=> Type::Int()],
			'org_id'    => ['type'	=> Type::Int()],
			'name'      => ['type'	=> Type::String()],
			'category'  => ['type'	=> Type::String()],
			'is_active' => ['type'	=> Type::Boolean()],
			'org_id' 	=> ['type'	=> Type::Int()],
		];
	}

	public function resolve($root, $args)
	{
		return JobStore::dispatchNow(isset($args['id']) ? $args['id'] : null, $args);
	}
}