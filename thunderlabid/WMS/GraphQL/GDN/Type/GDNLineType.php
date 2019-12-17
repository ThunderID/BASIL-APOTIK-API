<?php

namespace Thunderlabid\WMS\GraphQL\GDN\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\WMS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class GDNLineType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'WMSGDNLine',
    ];

    public function fields()
    {
        return [
            'product_id' => ['type' => Type::Int()],
            'sku'        => ['type' => Type::string()],
            'name'       => ['type' => Type::string()],
            'qty'        => ['type' => Type::float()],
            'expired_at' => ['type' => Type::string()],
            /*----------  RELATION  ----------*/
        ];
    }

}