<?php

namespace Thunderlabid\Accounting\GraphQL\JournalEntry\Mutation;

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
use Thunderlabid\Accounting\Job\JournalEntry\Cancel as JobCancel;
/*=====  End of DOMAIN  ======*/


class Cancel extends Mutation
{
	protected $attributes = [
		'name' => 'Cancel'
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
			'id' => 	['type'	=> Type::Int(), 'rules' => ['required']],
		];
	}

	public function resolve($root, $args)
	{
		return JobCancel::dispatchNow($args['id']);
	}
}