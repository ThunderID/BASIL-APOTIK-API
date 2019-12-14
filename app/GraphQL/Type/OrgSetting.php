<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

use Thunderlabid\POS\POSPoint;

class OrgSetting extends GraphQLType
{
    protected $attributes = [
        'name'        => 'OrgSetting',
        'description' => 'A type',
    ];

    public function fields()
    {
        return [
            'org_id'        => ['type' => Type::int(),   'description' => ''],
            'pos'           => ['type' => Type::listof(GraphQL::type('OrgSettingPOS')), 'description' => ''],
        ];
    }
}