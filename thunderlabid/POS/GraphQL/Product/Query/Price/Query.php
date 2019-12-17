<?php

namespace Thunderlabid\POS\GraphQL\Product\Query\Price;

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
use Thunderlabid\POS\Job\Product\Price\Query as JobQuery;
/*=====  End of DOMAIN  ======*/

class Query extends GQLQuery
{
	use OrderByTrait, PaginationTrait, SoftDeleteTrait, TimestampTrait;

	public function type()
	{
		return GraphQL::paginate('POSPrice');
	}

	public function authorize(array $args)
	{
		return true;
	}

	public function args()
	{
		return [
			'product_id'   => ['type' => Type::int()],
			'active_at_gt' => ['type' => Type::String()],
			'active_at_gte'=> ['type' => Type::String()],
			'active_at_lt' => ['type' => Type::String()],
			'active_at_lte'=> ['type' => Type::String()],
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