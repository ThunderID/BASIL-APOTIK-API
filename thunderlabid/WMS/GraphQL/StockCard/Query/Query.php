<?php

namespace Thunderlabid\WMS\GraphQL\StockCard\Query;

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
use Thunderlabid\WMS\Job\StockCard\Query as JobQuery;
/*=====  End of DOMAIN  ======*/

class Query extends GQLQuery
{
	use OrderByTrait, PaginationTrait, SoftDeleteTrait, TimestampTrait;

	public function type()
	{
		return GraphQL::paginate('WMSStockCard');
	}

	public function authorize(array $args)
	{
		return true;
	}

	public function args()
	{
		return [
			'id'        => [ 'type'	=> Type::Int()],
			'except_id' => [ 'type'	=> Type::listOf(Type::Int())],
			'no'        => [ 'type'	=> Type::String()],
			'date_gt'   => [ 'type'	=> Type::String()],
			'date_gte'  => [ 'type'	=> Type::String()],
			'date_lt'   => [ 'type'	=> Type::String()],
			'date_lte'  => [ 'type'	=> Type::String()],
			'warehouse_id' 		=> ['type' => Type::int()],
			'product_id' 		=> ['type' => Type::int()],
			'except_id' 		=> ['type'	=> Type::listOf(Type::Int())],
			'product_name'		=> ['type' => Type::String()],
			'group_by_product'	=> ['type' => Type::Boolean()],

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