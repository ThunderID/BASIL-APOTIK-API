<?php

namespace Thunderlabid\WMS\GraphQL\GRN\Mutation;

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
use Thunderlabid\WMS\Job\GRN\Delete as DomainDelete;
/*=====  End of DOMAIN  ======*/


class Delete extends Mutation
{
	protected $attributes = [
		'name' => 'Delete'
	];

	public function type()
	{
		return Type::Boolean();
	}

	public function authorize(array $args)
	{
		return true;
	}

	public function args()
	{
		return [
			'id' => 	['type'	=> Type::Int()],
		];
	}

	public function resolve($root, $args)
	{
		return DomainDelete::dispatchNow($args['id']);
	}
}