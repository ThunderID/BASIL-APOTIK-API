<?php

namespace Thunderlabid\WMS\GraphQL\Warehouse\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\WMS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class WarehouseType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'Warehouse',
        // 'model'         => \Thunderlabid\WMS\Warehouse::class,
    ];

    public function fields()
    {
        return [
            'id'             => ['type' => Type::Int()],
            'org_id'         => ['type' => Type::string()],
            'name'           => ['type' => Type::string()],
            'department'     => ['type' => Type::string()],
            'is_active'      => ['type' => Type::Boolean()],
            'setting'        => ['type' => GraphQL::type('WMSWarehouseSetting')],

            /*----------  RELATION  ----------*/
            
        ] + $this->timestamp_fields();
    }

}