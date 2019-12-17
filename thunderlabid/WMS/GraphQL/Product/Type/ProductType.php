<?php

namespace Thunderlabid\WMS\GraphQL\Product\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\WMS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class ProductType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'WMSProduct',
        'model'         => \Thunderlabid\WMS\Product::class,
    ];

    public function fields()
    {
        return [
            'id'           => ['type' => Type::Int()],
            'code'         => ['type' => Type::string()],
            'name'         => ['type' => Type::string()],
            'group'        => ['type' => Type::string()],
            'description'  => ['type' => Type::string()],
            'threshold'    => ['type' => Type::Int()],
            'unit'         => ['type' => Type::string()],
            'is_amenity'            => ['type' => Type::boolean()],
            'is_additional_service' => ['type' => Type::boolean()],
            'org_id'       => ['type' => Type::string()],
            
            'guest_service'=> ['type' => Type::float(), 'description' => ''],
            'room_usage'   => ['type' => Type::float(), 'description' => ''],
            'latest_stock' => ['type' => Type::float(), 'description' => ''],

            /*----------  RELATION  ----------*/
            
        ] + $this->timestamp_fields();
    }

    protected function resolveGuestServiceField($root, $args) {
        return $root->room_service_details()->sum('qty');
    }

    protected function resolveRoomUsageField($root, $args) {
        return $root->amenity_usages()->sum('qty');
    }

    protected function resolveLatestStockField($root, $args) {
        return $root->stock_cards()->sum('qty');
    }
}