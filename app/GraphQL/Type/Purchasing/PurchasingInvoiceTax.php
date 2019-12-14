<?php

namespace App\GraphQL\Type\Purchasing;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class PurchasingInvoiceTax extends GraphQLType
{
    protected $attributes = [
        'name'          => 'PurchasingInvoiceTax',
        'description'   => 'A type'

    ];
    
    public function fields()
    {
        return [
            'description'   => ['type' => Type::int(), 'description' => ''],
            'amount'        => ['type' => Type::float(), 'description' => ''],
        ];
    }
}
