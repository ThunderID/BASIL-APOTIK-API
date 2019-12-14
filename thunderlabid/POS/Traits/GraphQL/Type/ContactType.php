<?php

namespace Thunderlabid\POS\Traits\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\libraries\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\libraries\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\libraries\GraphQL\Type\HasUUIDGQLTypeTrait;

class ContactType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'Contact',
    ];

    public function fields()
    {
        return [
            'id'      => ['type' => Type::nonNull(Type::Int())],
            'type'    => ['type' => Type::String()],
            'contact' => ['type' => Type::String()],

            /* RELATIONS */
        ] + $this->timestamp_fields() + $this->softdelete_fields(); 
    }

}