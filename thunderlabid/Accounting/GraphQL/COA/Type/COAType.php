<?php

namespace Thunderlabid\Accounting\GraphQL\COA\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\Accounting\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class COAType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'COA',
        'model'         => \Thunderlabid\Accounting\COA::class,
    ];

    public function fields()
    {
        return [
            'id'            => [ 'type' => Type::nonNull(Type::Int())],
            'org_id'        => ['type' => Type::int()],
            'type'          => [ 'type' => Type::string()],
            'code'          => [ 'type' => Type::string()],
            'name'          => [ 'type' => Type::string()],
            'is_archived'   => [ 'type' => Type::boolean()],
            'is_locked'     => [ 'type' => Type::boolean()],
            'has_subsidiary'=> [ 'type' => Type::boolean()],

            /* RELATIONS */
        ] + $this->timestamp_fields() + $this->softdelete_fields(); 
    }

}