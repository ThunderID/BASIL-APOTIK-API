<?php

namespace Thunderlabid\POS\GraphQL\Invoice\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\POS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class InvoiceContainType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'POSInvoiceContain',
    ];

    public function fields()
    {
        return [
            'product_id' => ['type' => Type::Int()],
            'code'       => ['type' => Type::string()],
            'name'       => ['type' => Type::string()],
            'qty'        => ['type' => Type::float()],
            'price'      => ['type' => Type::float()],
            'discount'   => ['type' => Type::float()],

            /*----------  RELATION  ----------*/
            
        ];
    }

}