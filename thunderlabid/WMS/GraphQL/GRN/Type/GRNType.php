<?php

namespace Thunderlabid\WMS\GraphQL\GRN\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\WMS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class GRNType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'WMSGRN',
        // 'model'         => \Thunderlabid\WMS\GRN::class,
    ];

    public function fields()
    {
        return [
            'id'        => ['type' => Type::Int()],
            'no'        => ['type' => Type::string()],
            'ref_id'    => ['type' => Type::Int()],
            'ref_type'  => ['type' => Type::string()],
            'date'      => ['type' => Type::string()],
            'lines'     => ['type' => Type::listOf(GraphQL::Type('WMSGRNLine'))],
            'warehouse' => ['type' => GraphQL::Type('WMSWarehouse')],
            /*----------  RELATION  ----------*/
            
        ] + $this->timestamp_fields();
    }


    public function resolveDateField($root, $args)
    {
        return $root->date ? $root->date->toDateTimeString() : null;
    }
}
