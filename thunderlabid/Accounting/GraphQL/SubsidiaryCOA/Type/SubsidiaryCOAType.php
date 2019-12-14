<?php

namespace Thunderlabid\Accounting\GraphQL\SubsidiaryCOA\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\Accounting\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class SubsidiaryCOAType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'SubsidiaryCOA',
        'model'         => \Thunderlabid\Accounting\SubsidiaryCOA::class,
    ];

    public function fields()
    {
        return [
            'id'          => [ 'type' => Type::nonNull(Type::Int())],
            'coa_id'      => [ 'type' => Type::Int()],
            'code'        => [ 'type' => Type::string()],
            'name'        => [ 'type' => Type::string()],
            'data'        => [ 'type' => Type::string()],
            'description' => [ 'type' => Type::string()],
            'coa'         => [ 'type' => GraphQL::Type('COA')],


            /* RELATIONS */
        ] + $this->timestamp_fields() + $this->softdelete_fields(); 
    }

}