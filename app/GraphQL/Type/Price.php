<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class Price extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Price',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id'        => ['type' => Type::Int()],
            'active_at' => ['type' => Type::string()],
            'price'     => ['type' => Type::float()],
            'discount'  => ['type' => Type::float()],
            'created_at'   => ['type' => Type::string()],
            'updated_at'   => ['type' => Type::string()],
        ];
    }
}