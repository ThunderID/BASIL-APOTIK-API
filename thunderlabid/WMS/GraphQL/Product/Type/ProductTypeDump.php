<?php

namespace Thunderlabid\WMS\GraphQL\Product\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\WMS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class ProductTypeDump extends GraphQLType {

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
            'is_available' => ['type' => Type::boolean()],
            'org_id'       => ['type' => Type::string()],

            /*----------  RELATION  ----------*/
            
        ] + $this->timestamp_fields();
    }
}