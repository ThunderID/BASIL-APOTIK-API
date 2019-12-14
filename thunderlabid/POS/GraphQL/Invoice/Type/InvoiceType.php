<?php

namespace Thunderlabid\POS\GraphQL\Invoice\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\POS\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\POS\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class InvoiceType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'POSInvoice',
        // 'model'         => \Thunderlabid\POS\Invoice::class,
    ];

    public function fields()
    {
        return [
            'id'        => ['type' => Type::Int()],
            'no'        => ['type' => Type::string()],
            'date'      => ['type' => Type::string()],
            'customer'  => ['type' => Type::string()],
            'lines'     => ['type' => Type::listOf(GraphQL::Type('POSInvoiceLine'))],
            'discount'  => ['type' => Type::Float()],
            'tax'       => ['type' => Type::Float()],
            'is_active'     => ['type' => Type::boolean()],
            'cancelled_at'  => ['type' => Type::string()],
            'settlements'   => ['type' => Type::listOf(GraphQL::Type('POSSettlement'))],

            /*----------  RELATION  ----------*/
            
        ] + $this->timestamp_fields();
    }


    public function resolveDateField($root, $args)
    {
        return $root->date ? $root->date->toDateTimeString() : null;
    }
}
