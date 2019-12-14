<?php

namespace Thunderlabid\POS\Traits\GraphQL\Query;

/*=================================
=            Framework            =
=================================*/
use GraphQL\Type\Definition\Type;

trait TimestampTrait {

    public function args_timestamp()
    {
        return [
            'created_at_gt' => [    
                'name'  => 'created_at_gt',
                'type'  => Type::String()           
            ],
            'created_at_gte' => [   
                'name'  => 'created_at_gte',
                'type'  => Type::String()           
            ],
            'created_at_lt' => [    
                'name'  => 'created_at_lt',
                'type'  => Type::String()           
            ],
            'created_at_lte' => [   
                'name'  => 'created_at_lte',
                'type'  => Type::String()           
            ],

            'updated_at_gt' => [    
                'name'  => 'updated_at_gt',
                'type'  => Type::String()           
            ],
            'updated_at_gte' => [   
                'name'  => 'updated_at_gte',
                'type'  => Type::String()           
            ],
            'updated_at_lt' => [    
                'name'  => 'updated_at_lt',
                'type'  => Type::String()           
            ],
            'updated_at_lte' => [   
                'name'  => 'updated_at_lte',
                'type'  => Type::String()           
            ],
        ];
    }
}