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
use Thunderlabid\Accounting\Job\JournalEntry\Store as StoreJournalEntry;
use Thunderlabid\Accounting\Job\JournalEntry\UpdateStatus;
use Thunderlabid\Accounting\Status;
/*=====  End of DOMAIN  ======*/


class Store extends Mutation
{
	protected $attributes = [
		'name' => 'Store'
	];

	public function type()
	{
		return GraphQL::type('JournalEntry');
	}

	public function authorize(array $args)
  {
    return true;
  }

	public function args()
	{
		return [
			'id'        => ['type'	=> Type::Int()],
            'org_id'    => ['type' => Type::int()],
			'ref_type'  => ['type'	=> Type::String()],
			'ref_id'    => ['type'	=> Type::Int()],
			'date'      => ['type'	=> Type::String()],
			'locked_at' => ['type'	=> Type::String()],
			'void_at'   => ['type'	=> Type::String()],
			'note'      => ['type'	=> Type::String()],
			'lines'     => ['type'	=> Type::ListOf(GraphQL::type('IJournalEntryLine'))],
		];
	}

	public function resolve($root, $args)
	{
		return StoreJournalEntry::dispatchNow(isset($args['id']) ? $args['id'] : null, $args);
	}
}