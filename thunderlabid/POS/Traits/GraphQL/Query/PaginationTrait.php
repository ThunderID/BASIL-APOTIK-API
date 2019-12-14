<?php

namespace Thunderlabid\POS\Traits\GraphQL\Query;

/*=================================
=            Framework            =
=================================*/
use GraphQL\Type\Definition\Type;

trait PaginationTrait {

    public function args_pagination()
    {
        return [
            'limit' => [    
                'name'  => 'limit',
                'type'  => Type::Int()              
            ],
            'page' => [ 
                'name'  => 'page',
                'type'  => Type::Int()              
            ],
        ];
    }
}