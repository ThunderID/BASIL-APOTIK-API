<?php

namespace Thunderlabid\POS\GraphQL\Invoice\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\POS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class InvoiceLineType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'POSInvoiceLine',
    ];

    public function fields()
    {
        return [
            'name'       => ['type' => Type::string()],
            'qty'        => ['type' => Type::float()],
            'price'      => ['type' => Type::float()],
            'discount'   => ['type' => Type::float()],
            'contains'   => ['type' => Type::listof(GraphQL::type('POSInvoiceContain'))],

            /*----------  RELATION  ----------*/
            
        ];
    }

}