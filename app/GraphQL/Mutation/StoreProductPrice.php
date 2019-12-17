<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;

use App\Org;
use App\Price;
use App\Product;

class StoreProductPrice extends Mutation
{
    protected $attributes = [
        'name' => 'StoreProductPrice',
        'description' => 'Tambah produk baru'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Price::find($args['id']) : app()->make(Price::class)->fill($args)
                                );
    }

    public function type()
    {
        return GraphQL::type('Price');
    }

    public function args()
    {
        return [
            'id'           => ['type' => Type::Int()],
            'product_id'   => ['type' => Type::Int()],
            'active_at'    => ['type' => Type::string(), 'description' => 'in iso time'],
            'price'        => ['type' => Type::float(), 'description' => ''],
            'discount'     => ['type' => Type::float(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'id'           => ['nullable', 'exists:' . app()->make(Price::class)->getTable() . ',id'],
            'product_id'   => ['required', 'exists:' . app()->make(Product::class)->getTable() . ',id'],
            'active_at'    => ['required_without:id', 'string'],
            'price'        => ['required_without:id', 'numeric'],
            'discount'     => ['required_without:id', 'numeric'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        \DB::beginTransaction();

        $price = isset($args['id']) ? Price::find($args['id']) : new Price;
        $price->fill($args);
        $price->save();

        \DB::commit();

        return $price;
    }
}
