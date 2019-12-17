<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GraphQL;
use Auth;
use App\Price;

class ProductPrices extends Query
{
    protected $attributes = [
        'name' => 'ProductPrices',
        'description' => 'Lihat daftar produk'
    ];

    const LIMIT = 25;

    public function type()
    {
        return GraphQL::paginate('Price');
    }

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can('view', new Price);
    }

    public function args()
    {
        return [
            'id'            => ['type'  => Type::Int()],
            'product_id'    => ['type' => Type::int()],
            'page'          => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
            'limit'         => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],

            'actived_at_lt'   => ['type'  => Type::String()],
            'actived_at_lte'  => ['type'  => Type::String()],
            'actived_at_gt'   => ['type'  => Type::String()],
            'actived_at_gte'  => ['type'  => Type::String()],
            'order_desc'      => ['type'  => Type::boolean()],
            'order_by'        => ['type'  => Type::String()],
            'group_by_product'  => ['type'  => Type::boolean()],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with   = $fields->getRelations();
        $desc   = 'desc';

        $q = new Price;

        if ($with)
        {
            $q = $q->with($with);
        }

        foreach ($args as $k => $v)
        {
            switch ($k) 
            {
                case 'product_id': $q = $q->where('product_id', $v); break;

                case 'actived_at_lt':  $q = $q->where('actived_at', '<', $v); break;
                case 'actived_at_lte': $q = $q->where('actived_at', '<=', $v); break;
                case 'actived_at_gt':  $q = $q->where('actived_at', '>', $v); break;
                case 'actived_at_gte': $q = $q->where('actived_at', '>=', $v); break;

                case 'order_desc':   
                    if(!$v){
                        $desc   = 'asc'; 
                    }
                break;
                case 'order_by':    $q = $q->orderby($v, $desc); break;
                case 'group_by_product': 
                        $q  = $q->selectraw('product_id')
                            ->selectraw('avg(price) as price')
                            ->selectraw('avg(discount) as discount')
                            ->selectraw('max(actived_at) as actived_at')
                            ->selectraw('max(created_at) as created_at')
                            ->selectraw('max(updated_at) as updated_at')
                            ->groupby('product_id')
                            ; 
                    break;
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