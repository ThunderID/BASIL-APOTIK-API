<?php

namespace Thunderlabid\POS\GraphQL\Product\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\POS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class PriceType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'Price',
        // 'model'         => \Thunderlabid\POS\Price::class,
    ];

    public function fields()
    {
        return [
            'id'        => ['type' => Type::Int()],
            'active_at' => ['type' => Type::string()],
            'price'     => ['type' => Type::float()],
            'discount'  => ['type' => Type::float()],

            /*----------  RELATION  ----------*/
            
        ] + $this->timestamp_fields();
    }

    public function resolveActiveAtField($root, $args)
    {
        return $root->active_at ? $root->active_at->toDateTimeString() : null;
    }
}