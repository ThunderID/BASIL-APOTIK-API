<?php

namespace Thunderlabid\POS\GraphQL\POSPoint\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\POS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class POSPointType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'POSPoint',
        // 'model'         => \Thunderlabid\POS\POSPoint::class,
    ];

    public function fields()
    {
        return [
            'id'             => ['type' => Type::Int()],
            'org_id'         => ['type' => Type::string()],
            'name'           => ['type' => Type::string()],
            'category'       => ['type' => Type::string()],
            'is_active'      => ['type' => Type::Boolean()],
            'setting'        => ['type' => GraphQL::type('POSPointSetting')],

            /*----------  RELATION  ----------*/
            
        ] + $this->timestamp_fields();
    }

}