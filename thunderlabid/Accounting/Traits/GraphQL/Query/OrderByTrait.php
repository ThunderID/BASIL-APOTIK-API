<?php

namespace Thunderlabid\Accounting\Traits\GraphQL\Query;

/*=================================
=            Framework            =
=================================*/
use GraphQL\Type\Definition\Type;

trait OrderByTrait {

    public function args_orderby()
    {
        return [
            'order_by' => [    
                'name'  => 'order_by',
                'type'  => Type::String()              
            ],
            'order_desc' => [ 
                'name'  => 'order_desc',
                'type'  => Type::Boolean()
            ],
        ];
    }
}