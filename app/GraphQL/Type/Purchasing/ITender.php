<?php

namespace App\GraphQL\Type\Purchasing;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class ITender extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ITender',
        'description'   => 'A type'

    ];
    
    protected $inputObject = true;

    public function fields()
    {
        return [
            'partner_id'    => ['type' => Type::int(), 'description' => ''],
            'price'         => ['type' => Type::float(), 'description' => ''],
            'discount'      => ['type' => Type::float(), 'description' => ''],
        ];
    }
}
