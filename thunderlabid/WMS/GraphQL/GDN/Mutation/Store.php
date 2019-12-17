<?php

namespace Thunderlabid\WMS\GraphQL\GDN\Mutation;

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
use Thunderlabid\WMS\Job\GDN\Store as JobStore;
/*=====  End of DOMAIN  ======*/

use App\Models\Record\RoomService;

class Store extends Mutation
{
	protected $attributes = [
		'name' => 'Store'
	];

	public function type()
	{
		return GraphQL::type('WMSGDN');
	}

	public function args()
	{
		return [
			'id'       => ['type' => Type::Int()],
			'no'       => ['type' => Type::String()],
			'date'     => ['type' => Type::String()],
			// 'ref_id'   => ['type' => Type::Int()],
			// 'ref_type' => ['type' => Type::String(), 'description' => 'in:ROOMSERVICE'],
			'lines'    => ['type' => Type::ListOf(GraphQL::type("WMSIGDNLine"))],
			'warehouse_id' 	=> ['type' => Type::int()],
		];
	}

	public function resolve($root, $args)
	{
		// switch (strtoupper($args['ref_type'])) {
		// 	case 'ROOMSERVICE':
		// 		$args['ref_type'] 	= get_class(new RoomService);
		// 		break;
		// }
		return JobStore::dispatchNow(isset($args['id']) ? $args['id'] : null, $args);
	}
}