<?php

namespace App\GraphQL\Type\Purchasing;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class PurchasingInvoice extends GraphQLType
{
    protected $attributes = [
        'name'          => 'PurchasingInvoice',
        'description'   => 'A type'

    ];

    public function fields()
    {
        return [
            'id'            => ['type' => Type::Int(), 'description' => ''],
            'org_id'        => ['type' => Type::Int(), 'description' => ''],
            'partner_id'    => ['type' => Type::Int(), 'description' => ''],
            'warehouse_id'  => ['type' => Type::Int(), 'description' => ''],
            'no'            => ['type' => Type::string(), 'description' => ''],
            'issued_at'     => ['type' => Type::string(), 'description' => ''],
            'lines'         => ['type' => Type::listof(GraphQL::type('PurchasingInvoiceLine')), 'description' => ''],
            'org'           => ['type' => GraphQL::type('Org'), 'description' => ''],
            'partner'       => ['type' => GraphQL::type('Partner'), 'description' => ''],
        ];
    }
}