<?php

namespace Thunderlabid\WMS\GraphQL\StockCard\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\WMS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class StockCardType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'WMSStockCard',
        // 'model'         => \Thunderlabid\WMS\StockCard::class,
    ];

    public function fields()
    {
        return [
            'id'            => ['type' => Type::Int()],
            'warehouse_id'  => ['type' => Type::Int()],
            'ref_id'        => ['type' => Type::Int()],
            'ref_type'      => ['type' => Type::string()],
            'product_id'    => ['type' => Type::Int()],
            'qty'           => ['type' => Type::Float()],
            'sku'           => ['type' => Type::string()],
            'expired_at'    => ['type' => Type::string()],
            'date'          => ['type' => Type::string()],
            'group_by_product'  => ['type' => Type::boolean()],
            'product'       => ['type' => GraphQL::type('WMSProduct')],
            'warehouse'     => ['type' => GraphQL::type('WMSWarehouse')],

            /*----------  RELATION  ----------*/
            
        ] + $this->timestamp_fields();
    }


    public function resolveDateField($root, $args)
    {
        return $root->date ? $root->date->toDateTimeString() : null;
    }

    public function resolveExpiredAtField($root, $args)
    {
        return $root->expired_at ? $root->expired_at->toDateTimeString() : null;
    }
}
