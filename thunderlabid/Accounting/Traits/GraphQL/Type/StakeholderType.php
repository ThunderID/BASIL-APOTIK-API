<?php

namespace Thunderlabid\Accounting\Traits\GraphQL\Type;

use GraphQL;
use Rebing\GraphQL\Support\UnionType;

use App\Data\Passport\User;
use Thunderlabid\Purchasing\Supplier;

class StakeholderType extends UnionType
{
    protected $attributes = [
        'name' => 'StakeholderType',
    ];

    public function types()
    {
        return [
            GraphQL::type('User'),
            GraphQL::type('Supplier'),
        ];
    }

    public function resolveType($value)
    {
        if ($value instanceof User) {
            return GraphQL::type('User');
        } elseif ($value instanceof Supplier) {
            return GraphQL::type('Supplier');
        }
    }
}