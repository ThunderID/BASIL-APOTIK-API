<?php

namespace App\GraphQL\Type\Purchasing;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;
use App\Partner;

class Tender extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Tender',
        'description'   => 'A type'

    ];

    public function fields()
    {
        return [
            'partner_id'    => ['type' => Type::int(), 'description' => ''],
            'price'         => ['type' => Type::float(), 'description' => ''],
            'discount'      => ['type' => Type::float(), 'description' => ''],
            'partner'       => ['type' => GraphQL::type('Partner'), 'description' => ''],
        ];
    }
    
    protected function resolvePartnerField($root, $args) {
        if(isset($root['partner_id'])){
            return Partner::find($root['partner_id']);
        }
        return null;
    }
}
