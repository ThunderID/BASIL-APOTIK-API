<?php

namespace Thunderlabid\POS\GraphQL\Settlement\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\POS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class SettlementType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'Settlement',
        'model'         => \Thunderlabid\POS\Settlement::class,
    ];

    public function fields()
    {
        return [
            'id'     => ['type' => Type::Int()],
            'no'     => ['type' => Type::string()],
            'date'   => ['type' => Type::string()],
            'type'   => ['type' => Type::string()],
            'ref_no' => ['type' => Type::string()],
            'amount' => ['type' => Type::float()],
            'cancelled_at'  => ['type' => Type::string()],

            /*----------  RELATION  ----------*/
            
        ] + $this->timestamp_fields();
    }

    public function resolveDateField($root, $args)
    {
        return $root->date ? $root->date->toDateTimeString() : null;
    }
}