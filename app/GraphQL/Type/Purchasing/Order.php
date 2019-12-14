<?php

namespace App\GraphQL\Type\Purchasing;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class Order extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Order',
        'description'   => 'A type'

    ];

    public function fields()
    {
        return [
            'id'            => ['type' => Type::Int(), 'description' => ''],
            'org_id'        => ['type' => Type::Int(), 'description' => ''],
            'partner_id'    => ['type' => Type::Int(), 'description' => ''],
            'no'            => ['type' => Type::string(), 'description' => ''],
            'date'          => ['type' => Type::string(), 'description' => ''],
            'closed_at'     => ['type' => Type::string(), 'description' => ''],
            'lines'         => ['type' => Type::listof(GraphQL::type('PurchaseOrderLine')), 'description' => ''],

            'org'       => ['type' => GraphQL::type('Org'), 'description' => ''],
            'partner'   => ['type' => GraphQL::type('Partner'), 'description' => ''],
        ];
    }
}