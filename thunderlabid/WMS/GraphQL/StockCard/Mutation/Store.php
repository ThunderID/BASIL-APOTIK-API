<?php

namespace Thunderlabid\WMS\GraphQL\StockCard\Mutation;

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
use Thunderlabid\WMS\Job\StockCard\Store as JobStore;
/*=====  End of DOMAIN  ======*/


class Store extends Mutation
{
	protected $attributes = [
		'name' => 'Store'
	];

	public function type()
	{
		return GraphQL::type('WMSStockCard');
	}

	public function args()
	{
		return [
			'id'            => ['type' => Type::Int()],
            'warehouse_id'  => ['type' => Type::Int()],
            'ref_id'        => ['type' => Type::Int()],
            'ref_type'      => ['type' => Type::string()],
            'product_id'    => ['type' => Type::Int()],
            'qty'           => ['type' => Type::Float()],
            'sku'           => ['type' => Type::string()],
            'expired_at'    => ['type' => Type::string()],
            'date'          => ['type' => Type::string()],
		];
	}

	public function resolve($root, $args)
	{
		return JobStore::dispatchNow(isset($args['id']) ? $args['id'] : null, $args);
	}
}