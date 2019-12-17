<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use App\Price;

class DeleteProductPrice extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteProductPrice',
        'description' => 'Hapus produk'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can('delete', Price::find($args['id']));
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
            'id'        => ['required', 'exists:' . app()->make(Price::class)->getTable() . ',id'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $price = Price::findorfail($args['id']);
        $price->delete();

        return true;
    }
}