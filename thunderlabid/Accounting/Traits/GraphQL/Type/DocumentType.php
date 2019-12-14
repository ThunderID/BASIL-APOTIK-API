<?php

namespace Thunderlabid\Accounting\Traits\GraphQL\Type;

use GraphQL;
use Rebing\GraphQL\Support\UnionType;

use Thunderlabid\Purchasing\PurchaseOrder;
use Thunderlabid\Accounting\GRN;
use Thunderlabid\Accounting\DeliveryOrder;
use Thunderlabid\Sales\SalesOrder;

class DocumentType extends UnionType
{
    protected $attributes = [
        'name' => 'DocumentType',
    ];

    public function types()
    {
        return [
            GraphQL::type('PurchaseOrder'),
            // GraphQL::type('SalesPO'),
            GraphQL::type('GRN'),
            GraphQL::type('DeliveryOrder'),
        ];
    }

    public function resolveType($value)
    {
        if ($value instanceof PurchaseOrder) {
            return GraphQL::type('PurchaseOrder');
        } elseif ($value instanceof SalesOrder) {
            return GraphQL::type('SalesOrder');
        } elseif ($value instanceof GRN) {
            return GraphQL::type('GRN');
        } elseif ($value instanceof DeliveryOrder) {
            return GraphQL::type('DeliveryOrder');
        }
    }
}