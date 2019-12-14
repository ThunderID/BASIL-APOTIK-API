<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class OrgSettingPOS extends GraphQLType
{
    protected $attributes = [
        'name'        => 'OrgSettingPOS',
        'description' => 'A type',
    ];

    public function fields()
    {
        return [
            'type'          => ['type' => Type::string(),   'description' => ''],
            'pos_points'    => ['type' => Type::listof(GraphQL::type('POSPoint')), 'description' => ''],
        ];
    }
}