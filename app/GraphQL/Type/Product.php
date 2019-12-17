<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class Product extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Product',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id'           => ['type' => Type::Int()],
            'code'         => ['type' => Type::string()],
            'name'         => ['type' => Type::string()],
            'group'        => ['type' => Type::string()],
            'description'  => ['type' => Type::string()],
            'threshold'    => ['type' => Type::Int()],
            'unit'         => ['type' => Type::string()],
            'created_at'   => ['type' => Type::string()],
            'updated_at'   => ['type' => Type::string()],
            
            'price'        => ['type' => GraphQL::type('Price')],
            'prices'       => ['type' => Type::listOf(GraphQL::type('Price'))],
        ];
    }
}