<?php

namespace Thunderlabid\Cashier\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

class CashierLog extends GraphQLType
{
    protected $attributes = [
        'name' => 'CashierLog',
        'description' => 'A type',

    ];

    public function fields()
    {
        return [
            'id'        => ['type' => Type::Int(), 'description' => ''],
            'method'    => ['type' => Type::String(), 'description' => ''],
            'amount'    => ['type' => Type::float(), 'description' => ''],
            'ref_id'    => ['type' => Type::Int(), 'description' => ''],
            'ref_type'  => ['type' => Type::String(), 'description' => ''],
            'balance'   => ['type' => Type::float(), 'description' => ''],
        ];
    }

    protected function resolveBalanceField($root, $args){
        return $root->cashier_session->cashier_logs->where('created_at', '<=', $root->created_at)->sum('amount') + $root->cashier_session->opening_balance;
    }
}