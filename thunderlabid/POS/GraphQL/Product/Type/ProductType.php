<?php

namespace Thunderlabid\POS\GraphQL\Product\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\POS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class ProductType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'POSProduct',
        // 'model'         => \Thunderlabid\POS\Product::class,
    ];

    public function fields()
    {
        return [
            'id'           => ['type' => Type::Int()],
            'pos_point_id' => ['type' => Type::Int()],
            'code'         => ['type' => Type::string()],
            'name'         => ['type' => Type::string()],
            'group'        => ['type' => Type::string()],
            'description'  => ['type' => Type::string()],
            'is_available' => ['type' => Type::boolean()],

            /*----------  RELATION  ----------*/
            'price'        => ['type' => GraphQL::type('POSPrice')],
            'prices'       => ['type' => Type::listOf(GraphQL::type('POSPrice'))],
            'pos_point'    => ['type' => GraphQL::type('POSPoint')],
            
        ] + $this->timestamp_fields();
    }
}