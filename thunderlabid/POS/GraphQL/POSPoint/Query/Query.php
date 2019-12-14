<?php

namespace Thunderlabid\POS\GraphQL\POSPoint\Query;

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
use Thunderlabid\POS\Traits\GraphQL\Query\OrderByTrait;
use Thunderlabid\POS\Traits\GraphQL\Query\PaginationTrait;
use Thunderlabid\POS\Traits\GraphQL\Query\SoftDeleteTrait;
use Thunderlabid\POS\Traits\GraphQL\Query\TimestampTrait;
/*=====  End of Trait  ======*/

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\POS\Job\POSPoint\Query as JobQuery;
/*=====  End of DOMAIN  ======*/

class Query extends GQLQuery
{
	use OrderByTrait, PaginationTrait, SoftDeleteTrait, TimestampTrait;

	public function type()
	{
		return GraphQL::paginate('POSPoint');
	}

	public function authorize(array $args)
	{
		return true;
	}

	public function args()
	{
		return [
			'id'             => [ 'type'	=> Type::Int()],
			'org_id'         => [ 'type'	=> Type::Int()],
			'except_id'      => [ 'type'	=> Type::listOf(Type::Int())],
			'name'           => [ 'type'	=> Type::String()],
			'is_active'      => [ 'type'	=> Type::Boolean()],
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