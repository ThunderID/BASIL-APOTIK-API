<?php

namespace App\GraphQL\Type\Purchasing;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;
use Thunderlabid\WMS\Product;

class IPurchasingInvoiceLine extends GraphQLType
{
    protected $attributes = [
        'name'          => 'IPurchasingInvoiceLine',
        'description'   => 'A type'

    ];
    
    protected $inputObject = true;

    public function fields()
    {
        return [
            'product_id'    => ['type' => Type::int(), 'description' => ''],
            'qty'           => ['type' => Type::int(), 'description' => ''],
            'price'         => ['type' => Type::float(), 'description' => ''],
            'discount'      => ['type' => Type::float(), 'description' => ''],
        ];
    }
}
