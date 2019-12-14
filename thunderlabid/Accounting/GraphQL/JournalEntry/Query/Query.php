<?php

namespace Thunderlabid\Accounting\GraphQL\JournalEntry\Query;

/*=================================
=            Framework            =
=================================*/
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query as GQLQuery;
use GraphQL;
use Validator;
use Gate;
use App\Library\Helper;
use DB;
use Log;
/*=====  End of Framework  ======*/

/*=============================
=            Trait            =
=============================*/
use Thunderlabid\Accounting\Traits\GraphQL\Query\OrderByTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Query\PaginationTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Query\SoftDeleteTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Query\TimestampTrait;
/*=====  End of Trait  ======*/

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\Accounting\Job\JournalEntry\Query as JobQuery;
/*=====  End of DOMAIN  ======*/

class Query extends GQLQuery
{
	use OrderByTrait, PaginationTrait, SoftDeleteTrait, TimestampTrait;

	public function type()
	{
		return GraphQL::paginate('JournalEntry');
	}

	public function authorize(array $args)
	{
		return true;
	}

	public function args()
	{
		return [
			'id'        => ['type'	=> Type::Int()],
			'except_id' => ['type'	=> Type::listOf(Type::String())],

			'ref_type'  => ['type'	=> Type::String()],
			'ref_id'    => ['type'	=> Type::Int()],
			
			'no'        => ['type'	=> Type::String()],
			'date_gt'   => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],
			'date_gte'  => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],
			'date_lt'   => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],
			'date_lte'  => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],

			'locked_at_gt'   => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],
			'locked_at_gte'  => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],
			'locked_at_lt'   => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],
			'locked_at_lte'  => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],

			'void_at_gt'   => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],
			'void_at_gte'  => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],
			'void_at_lt'   => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],
			'void_at_lte'  => ['type'	=> Type::String(),'rules'	=> ['sometimes', 'date']],

		] + $this->args_orderby() + $this->args_pagination() + $this->args_softdelete() + $this->args_timestamp();
	}

	public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
	{
		$select = $fields->getSelect();
		$with = $fields->getRelations();
		$data = app()->make(JobQuery::class)::dispatchNow($args);
		if (is_array($with)) $data->load(array_keys($with));

		return $data;
	}
}