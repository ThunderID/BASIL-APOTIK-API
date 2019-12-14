<?php

namespace Thunderlabid\POS\Traits\GraphQL\Query;

/*=================================
=            Framework            =
=================================*/
use GraphQL\Type\Definition\Type;

trait OrderByTrait {

    public function args_orderby()
    {
        return [
            'order_desc' => [ 
                'name'  => 'order_desc',
                'type'  => Type::Boolean()
            ],
            'order_by' => [    
                'name'  => 'order_by',
                'type'  => Type::String()              
            ],
        ];
    }
}