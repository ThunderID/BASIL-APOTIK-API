<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GraphQL;
use Auth;
use App\Product;

class Products extends Query
{
    protected $attributes = [
        'name' => 'Products',
        'description' => 'Lihat daftar produk'
    ];

    const LIMIT = 25;

    public function type()
    {
        return GraphQL::paginate('Product');
    }

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can('view', new Product);
    }

    public function args()
    {
        return [
            'id'    => ['type'  => Type::Int()],
            'org_id'       => ['type' => Type::int()],
            'code'         => ['type' => Type::String()],
            'name'         => ['type' => Type::String()],
            'group'        => ['type' => Type::String()],
            'page'  => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
            'limit' => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],

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
        $with   = $fields->getRelations();
        $desc   = 'desc';

        $q = new Product;

        if ($with)
        {
            $q = $q->with($with);
        }

        foreach ($args as $k => $v)
        {
            switch ($k) 
            {
                case 'org_id': $q = $q->where('org_id', $v); break;
                case 'code': $q = $q->where('code', 'like', $v); break;
                case 'name': $q = $q->where('name', 'like', $v); break;
                case 'group': $q = $q->where('group', 'like', $v); break;

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
                case 'order_by':    $q = $q->orderby($v, $desc); break;
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