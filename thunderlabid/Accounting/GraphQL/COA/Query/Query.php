<?php

namespace Thunderlabid\Accounting\GraphQL\COA\Query;

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
use Thunderlabid\Accounting\Job\COA\Query as JobQuery;
/*=====  End of DOMAIN  ======*/

class Query extends GQLQuery
{
	use OrderByTrait, PaginationTrait, SoftDeleteTrait, TimestampTrait;

	public function type()
	{
		return GraphQL::paginate('COA');
	}

	public function authorize(array $args)
	{
		return true;
	}

	public function args()
	{
		return [
			/*----------  ID  ----------*/
			'id'             => [ 'type' => Type::Int()],
			'except_id'      => [ 'type' => Type::listOf(Type::Int())],
			/*----------  FIELDS  ----------*/
			'type'           => [ 'type' => Type::String()],
			'code'           => [ 'type' => Type::String()],
			'name'           => [ 'type' => Type::String()],
			'is_archived'    => [ 'type' => Type::Boolean()],
			'is_locked'      => [ 'type' => Type::Boolean()],
			'has_subsidiary' => [ 'type' => Type::Boolean()],
			/*----------  RELATIONS  ----------*/

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