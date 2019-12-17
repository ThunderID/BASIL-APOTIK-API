<?php

namespace Thunderlabid\WMS\GraphQL\Warehouse\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

class WarehouseSettingType extends GraphQLType {

    protected $attributes = [
        'name'          => 'WarehouseSetting',
    ];

    public function fields()
    {
        return [
            'threshold'     => ['type' => Type::float()],
            /*----------  RELATION  ----------*/
        ];
    }

}