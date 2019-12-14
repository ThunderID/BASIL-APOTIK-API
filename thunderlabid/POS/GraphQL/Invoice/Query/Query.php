<?php

namespace Thunderlabid\POS\GraphQL\Invoice\Query;

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
use Thunderlabid\POS\Job\Invoice\Query as JobQuery;
/*=====  End of DOMAIN  ======*/

class Query extends GQLQuery
{
	use OrderByTrait, PaginationTrait, SoftDeleteTrait, TimestampTrait;

	public function type()
	{
		return GraphQL::paginate('POSInvoice');
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
			'customer'  => [ 'type'	=> Type::String()],
			'pos_point_id' 		=> ['type' => Type::int()],
			'has_settlement'    => ['type'  => Type::Boolean()],
			'has_cancelled'     => ['type'  => Type::Boolean()],

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