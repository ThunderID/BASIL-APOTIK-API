<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use App\Product;

class DeleteProduct extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteProduct',
        'description' => 'Hapus produk'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Product::find($args['id']) : app()->make(Product::class)->fill($args)
                                );
    }

    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return [
            'id'            => ['type'  => Type::int(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'id'        => ['required', 'exists:' . app()->make(Product::class)->getTable() . ',id'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $product = Product::findorfail($args['id']);
        $product->delete();

        return true;
    }
}