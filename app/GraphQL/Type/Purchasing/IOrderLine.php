<?php

namespace App\GraphQL\Type\Purchasing;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class IOrderLine extends GraphQLType
{
    protected $attributes = [
        'name'          => 'IOrderLine',
        'description'   => 'A type'

    ];
    
    protected $inputObject = true;

    public function fields()
    {
        return [
            'product_id'    => ['type' => Type::int(), 'description' => ''],
            'qty'           => ['type' => Type::int(), 'description' => ''],
            // 'tenders'       => ['type' => Type::listof(GraphQL::type('IPurchaseTender')), 'description' => ''],
        ];
    }
}
