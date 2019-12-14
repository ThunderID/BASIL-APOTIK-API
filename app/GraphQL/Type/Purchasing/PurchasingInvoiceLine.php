<?php

namespace App\GraphQL\Type\Purchasing;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;
use Thunderlabid\WMS\Product;

class PurchasingInvoiceLine extends GraphQLType
{
    protected $attributes = [
        'name'          => 'PurchasingInvoiceLine',
        'description'   => 'A type'

    ];

    public function fields()
    {
        return [
            'product_id'    => ['type' => Type::int(), 'description' => ''],
            'qty'           => ['type' => Type::int(), 'description' => ''],
            'price'         => ['type' => Type::float(), 'description' => ''],
            'discount'      => ['type' => Type::float(), 'description' => ''],
            // 'product'       => ['type' => GraphQL::type('WMSProduct'), 'description' => ''],
        ];
    }
    
    protected function resolveProductField($root, $args) {
        if(isset($root['product_id'])){
            return Product::find($root['product_id']);
        }
        return null;
    }
}
