<?php

namespace Thunderlabid\Accounting\GraphQL\COA\Mutation;

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
use Thunderlabid\Accounting\Job\COA\Store as DomainStore;
/*=====  End of DOMAIN  ======*/


class Store extends Mutation
{
	protected $attributes = [
		'name' => 'Store'
	];

	public function type()
	{
		return GraphQL::type('COA');
	}

	public function args()
	{
		return [
			'id'             => [ 'type'	=> Type::Int()],
            'org_id'    	 => ['type' => Type::int()],
			'type'           => [ 'type'	=> Type::String()],
			'code'           => [ 'type'	=> Type::String()],
			'name'           => [ 'type'	=> Type::String()],
			'is_archived'    => [ 'type'	=> Type::Boolean()],
			'is_locked'      => [ 'type'	=> Type::Boolean()],
			'has_subsidiary' => [ 'type'	=> Type::Boolean()],
		];
	}

	public function resolve($root, $args)
	{
		return DomainStore::dispatchNow(isset($args['id']) ? $args['id'] : null, $args);
	}
}