<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class User extends GraphQLType
{
    protected $attributes = [
        'name'        => 'User',
        'description' => 'A type',
    ];

    public function fields()
    {
        return [
            'id'                   => ['type' => Type::int(),   'description' => ''],
        	'name'                 => ['type' => Type::String(), 'description' => ''],
        	'email'                => ['type' => Type::String(), 'description' => ''],
        	'username'             => ['type' => Type::String(), 'description' => ''],
            'username_verified_at' => ['type' => Type::String(), 'description' => ''],
            'bio'                  => ['type' => GraphQL::Type('Bio'), 'description' => ''],
            'roles'                => ['type' => Type::listof(GraphQL::Type('Role')), 'description' => ''],
            'preferences'   => [
                'type'          => Type::listof(Type::string()), 
            ],
            'rate'          => [
                'type'          => Type::int(), 
            ],
            
            'created_at'    => ['type' => Type::string(),      'description' => ''],
            'updated_at'    => ['type' => Type::string(),      'description' => ''],
        ];
    }

    protected function resolvePreferencesField($root, $args) {
        $data   = [];
        foreach ($root->orders as $v) {
            foreach ($v->lines as $v2) {
                $data[]     = $v2->product->name.' '.$v2->note;
            }
        }
        return $data;
    }

    protected function resolveRateField($root, $args) {
        return round($root->stays->avg('rating')/4);
    }
}
