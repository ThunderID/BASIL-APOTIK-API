<?php

namespace Thunderlabid\WMS\Traits\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\libraries\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\libraries\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\libraries\GraphQL\Type\HasUUIDGQLTypeTrait;

class AddressType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'Address',
    ];

    public function fields()
    {
        return [
            'id'        => ['type' => Type::nonNull(Type::Int())],
            'address'   => ['type' => Type::String()],
            'city'      => ['type' => Type::String()],
            'province'  => ['type' => Type::String()],
            'country'   => ['type' => Type::String()],
            'WMStcode'  => ['type' => Type::String()],
            'latitude'  => ['type' => Type::Float()],
            'longitude' => ['type' => Type::Float()],

            /* RELATIONS */
        ] + $this->timestamp_fields() + $this->softdelete_fields(); 
    }

}