<?php

namespace Thunderlabid\WMS\GraphQL\GRN\Mutation;

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
use Thunderlabid\WMS\Job\GRN\Store as JobStore;
/*=====  End of DOMAIN  ======*/

use App\Models\Purchasing\Order;
use App\Models\Record\RoomService;

class Store extends Mutation
{
	protected $attributes = [
		'name' => 'Store'
	];

	public function type()
	{
		return GraphQL::type('WMSGRN');
	}

	public function args()
	{
		return [
			'id'       => ['type' => Type::Int()],
			'no'       => ['type' => Type::String()],
			'date'     => ['type' => Type::String()],
			// 'ref_id'   => ['type' => Type::Int()],
			// 'ref_type' => ['type' => Type::String(), 'description' => 'in:PURCHASEORDER/ROOMSERVICE'],
			'lines'    => ['type' => Type::ListOf(GraphQL::type("WMSIGRNLine"))],
			'warehouse_id' 	=> ['type' => Type::int()],
		];
	}

	public function resolve($root, $args)
	{
		// switch (strtoupper($args['ref_type'])) {
		// 	case 'PURCHASEORDER':
		// 		$args['ref_type'] 	= get_class(new Order);
		// 		break;
		// 	case 'ROOMSERVICE':
		// 		$args['ref_type'] 	= get_class(new RoomService);
		// 		break;
		// }
		return JobStore::dispatchNow(isset($args['id']) ? $args['id'] : null, $args);
	}
}
