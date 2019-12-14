<?php

namespace Thunderlabid\POS\GraphQL\POSPoint\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

class POSPointSettingType extends GraphQLType {

    protected $attributes = [
        'name'          => 'POSPointSetting',
    ];

    public function fields()
    {
        return [
            'tax'                       => ['type' => Type::float()],
            'service_tax'               => ['type' => Type::float()],
            'government_tax'            => ['type' => Type::float()],
            'table_no'                  => ['type' => Type::listof(Type::string())],
            'cancellation_in_seconds'   => ['type' => Type::int()],
            /*----------  RELATION  ----------*/
        ];
    }

}

