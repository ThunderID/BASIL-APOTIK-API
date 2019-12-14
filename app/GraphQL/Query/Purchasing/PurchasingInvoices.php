<?php

namespace App\GraphQL\Query\Purchasing;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GraphQL;
use Auth;
use App\Models\Purchasing\Invoice;

class PurchasingInvoices extends Query
{
	protected $attributes = [
		'name' => 'PurchasingInvoices',
		'description' => 'A query'
	];

	const LIMIT = 25;

	public function type()
	{
		return GraphQL::paginate('PurchasingInvoice');
	}

	public function authorize(array $args) : bool
	{
		return Auth::user() && Auth::user()->can('view', new Invoice);
	}

	public function args()
	{
		return [
			'id'            => ['type'  => Type::Int()],
			'org_id'        => ['type'  => Type::Int()],
			'partner_id'    => ['type'  => Type::Int()],
			'billing_name'  => ['type'  => Type::String()],
			'billing_phone' => ['type'  => Type::String()],
			'billing_address'	=> ['type'  => Type::String()],
			'issued_at_lt'		=> ['type'  => Type::String()],
			'issued_at_lte'		=> ['type'  => Type::String()],
			'issued_at_gt'		=> ['type'  => Type::String()],
			'issued_at_gte'		=> ['type'  => Type::String()],
			'issued_at'         => ['type'  => Type::String()],
			'no'            => ['type'  => Type::String()],
			'has_paid'      => ['type'  => Type::Boolean()],
			'paid_at_lt'    => ['type'  => Type::String()],
			'paid_at_lte'   => ['type'  => Type::String()],
			'paid_at_gt'    => ['type'  => Type::String()],
			'paid_at_gte'   => ['type'  => Type::String()],
			'paid_at'       => ['type'  => Type::String()],
			'page'          => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
			'limit'         => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],

			'created_at_lt'   => ['type'  => Type::String()],
			'created_at_lte'  => ['type'  => Type::String()],
			'created_at_gt'   => ['type'  => Type::String()],
			'created_at_gte'  => ['type'  => Type::String()],
			'updated_at_lt'   => ['type'  => Type::String()],
			'updated_at_lte'  => ['type'  => Type::String()],
			'updated_at_gt'   => ['type'  => Type::String()],
			'updated_at_gte'  => ['type'  => Type::String()],
			'order_desc'      => ['type'  => Type::boolean()],
			'order_by'        => ['type'  => Type::String()],

		];
	}

	public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
	{
		$select = $fields->getSelect();
		$with = $fields->getRelations();
		$desc   = 'desc';

		$q = new Invoice;

		if ($with)
		{
			$q = $q->with($with);
		}
		

		foreach ($args as $k => $v)
		{
			if(!is_null($v)){
				switch ($k) 
				{
					case 'id':          $q = $q->where('id', '=', $v); break;
					case 'org_id':      $q = $q->where('org_id', '=', $v); break;
					case 'partner_id':  $q = $q->where('partner_id', '=', $v); break;
					case 'billing_name':    $q = $q->where('billing_name', 'like', $v); break;
					case 'billing_phone':   $q = $q->where('billing_phone', 'like', $v); break;
					case 'billing_address':     $q = $q->where('billing_address', 'like', $v); break;
					case 'issued_at_lt':  $q = $q->where('issued_at', '<', $v); break;
					case 'issued_at_lte': $q = $q->where('issued_at', '<=', $v); break;
					case 'issued_at_gt':  $q = $q->where('issued_at', '>', $v); break;
					case 'issued_at_gte': $q = $q->where('issued_at', '>=', $v); break;
					case 'issued_at':     $q = $q->where('issued_at', $v); break;
					case 'paid_at_lt':    $q = $q->where('paid_at', '<', $v); break;
					case 'paid_at_lte':   $q = $q->where('paid_at', '<=', $v); break;
					case 'paid_at_gt':    $q = $q->where('paid_at', '>', $v); break;
					case 'paid_at_gte':   $q = $q->where('paid_at', '>=', $v); break;
					case 'paid_at':       $q = $q->where('paid_at', $v); break;
					case 'no':         $q = $q->where('no', 'like', $v); break;

					case 'has_paid':   
                        if($v){
                            $q = $q->wherenotnull('paid_at'); 
                        }else{
                            $q = $q->wherenull('paid_at'); 
                        }
                    break;

					case 'created_at_lt':  $q = $q->where('created_at', '<', $v); break;
					case 'created_at_lte': $q = $q->where('created_at', '<=', $v); break;
					case 'created_at_gt':  $q = $q->where('created_at', '>', $v); break;
					case 'created_at_gte': $q = $q->where('created_at', '>=', $v); break;
					case 'updated_at_lt':  $q = $q->where('updated_at', '<', $v); break;
					case 'updated_at_lte': $q = $q->where('updated_at', '<=', $v); break;
					case 'updated_at_gt':  $q = $q->where('updated_at', '>', $v); break;
					case 'updated_at_gte': $q = $q->where('updated_at', '>=', $v); break;
					case 'order_desc':
						if(!$v){
							$desc   = 'asc'; 
						}
					break;
					case 'order_by': $q = $q->orderby($v, $desc); break;
				}
			}
		}

		return $q->paginate(
			isset($args['limit']) ? $args['limit'] : Static::LIMIT,
			'*',
			'page',
			isset($args['page']) ? $args['page'] : 1
		);
	}
}