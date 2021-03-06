<?php

namespace Thunderlabid\WMS\GraphQL\GRN\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\WMS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\WMS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class IGRNLineType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $inputObject = true;

    protected $attributes = [
        'name'          => 'WMSIGRNLine',
    ];

    public function fields()
    {
        return [
            'product_id' => ['type' => Type::Int()],
            'name'       => ['type' => Type::string()],
            'sku'        => ['type' => Type::string()],
            'qty'        => ['type' => Type::float()],
            'expired_at' => ['type' => Type::string()],
            /*----------  RELATION  ----------*/
            
        ];
    }

}