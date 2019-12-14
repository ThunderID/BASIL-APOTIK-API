<?php

namespace Thunderlabid\Cashier\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

class CashierSession extends GraphQLType
{
    protected $attributes = [
        'name' => 'CashierSession',
        'description' => 'A type',

    ];

    public function fields()
    {
        return [
            'id'        => ['type' => Type::Int(), 'description' => ''],
            'user_id'   => ['type' => Type::Int(), 'description' => ''],
            'org_id'    => ['type' => Type::Int(), 'description' => ''],
            'opened_at' => ['type' => Type::String(), 'description' => ''],
            'closed_at' => ['type' => Type::String(), 'description' => ''],
            'department'=> ['type' => Type::String(), 'description' => ''],
            'opening_balance'   => ['type' => Type::float(), 'description' => ''],
            'closing_balance'   => ['type' => Type::float(), 'description' => ''],
            'session_balance'   => ['type' => Type::float(), 'description' => ''],
            'user'      => ['type' => GraphQL::type('User'), 'description' => ''],
            'org'       => ['type' => GraphQL::type('Org'), 'description' => ''],
            'cashier_logs'  => ['type' => Type::listof(GraphQL::type('CashierLog')), 'description' => ''],
        ];
    }

    protected function resolveOrgField($root, $args){
        return \App\Org::find($root['org_id']);
    }

    protected function resolveUserField($root, $args){
        return \App\User::find($root['user_id']);
    }

    // protected function resolveOpeningBalanceField($root, $args){
    //     return $root->cashier_logs->sortby('created_at')[0]['amount'];
    // }

    protected function resolveClosingBalanceField($root, $args){
        return $root->closing_balance * 1;
    }

    protected function resolveSessionBalanceField($root, $args){
        return array_sum(array_column($root->cashier_logs->toarray(), 'amount')) + $root->opening_balance;
    }
}