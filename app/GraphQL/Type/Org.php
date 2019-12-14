<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class Org extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Org',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id'       => ['type' => Type::int(), 'description' => ''],
            'name'     => ['type' => Type::string(), 'description' => ''],
            'address'  => ['type' => Type::string(), 'description' => ''],
            'city'     => ['type' => Type::string(), 'description' => ''],
            'province' => ['type' => Type::string(), 'description' => ''],
            'country'  => ['type' => Type::string(), 'description' => ''],
            'phone'    => ['type' => Type::string(), 'description' => ''],
            'geolocation'    => ['type' => GraphQL::type('Geolocation'), 'description' => ''],
            
            'org_group'     => ['type' => GraphQL::type('OrgGroup'), 'description' => ''],
            'pos_points'             => [
                'type'          => Type::listof(GraphQL::type('POSPoint')), 
                'description'   => '', 
                'args'          => [
                    'category'  => ['type'  => Type::string(), 'rules' => ['nullable']],
                ]
            ],
            'org_setting'     => ['type' => GraphQL::type('OrgSetting'), 'description' => ''],
        ];
    }

    protected function resolvePOSPointsField($root, $args){
        $points  = $root->pos_points;

        if(isset($args['category'])){
            $points = $points->where('category', $args['category']);
        }

        return $points;
    }
}