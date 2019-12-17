<?php

namespace Thunderlabid\WMS\GraphQL\Product\Query;

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
use Thunderlabid\WMS\Traits\GraphQL\Query\OrderByTrait;
use Thunderlabid\WMS\Traits\GraphQL\Query\PaginationTrait;
use Thunderlabid\WMS\Traits\GraphQL\Query\SoftDeleteTrait;
use Thunderlabid\WMS\Traits\GraphQL\Query\TimestampTrait;
/*=====  End of Trait  ======*/

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\WMS\Job\Product\Query as JobQuery;
/*=====  End of DOMAIN  ======*/

class Query extends GQLQuery
{
	use OrderByTrait, PaginationTrait, SoftDeleteTrait, TimestampTrait;

	public function type()
	{
		return GraphQL::paginate('WMSProduct');
	}

	public function authorize(array $args)
	{
		return true;
	}

	public function args()
	{
		return [
			'id' 	   	   => ['type' => Type::int()],
			'org_id' 	   => ['type' => Type::int()],
			'code'         => ['type' => Type::String()],
			'name'         => ['type' => Type::String()],
			'group'        => ['type' => Type::String()],
			'is_amenity' 			=> ['type' => Type::Boolean()],
			'is_additional_service' => ['type' => Type::Boolean()],
			'except_id'    => [ 'type'	=> Type::listOf(Type::Int())],
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