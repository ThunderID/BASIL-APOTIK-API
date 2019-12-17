<?php

namespace Thunderlabid\WMS\Traits\GraphQL\Query;

/*=================================
=            Framework            =
=================================*/
use GraphQL\Type\Definition\Type;

trait SoftDeleteTrait {

    public function args_softdelete()
    {
        return [
            'with_deleted' => [ 
                'name'  => 'with_deleted',
                'type'  => Type::Boolean()          
            ],
            'deleted_only' => [ 
                'name'  => 'deleted_only',
                'type'  => Type::Boolean()          
            ],
            'deleted_at_gt' => [    
                'name'  => 'deleted_at_gt',
                'type'  => Type::String()           
            ],
            'deleted_at_gte' => [   
                'name'  => 'deleted_at_gte',
                'type'  => Type::String()           
            ],
            'deleted_at_lt' => [    
                'name'  => 'deleted_at_lt',
                'type'  => Type::String()           
            ],
            'deleted_at_lte' => [   
                'name'  => 'deleted_at_lte',
                'type'  => Type::String()           
            ],
        ];
    }
}