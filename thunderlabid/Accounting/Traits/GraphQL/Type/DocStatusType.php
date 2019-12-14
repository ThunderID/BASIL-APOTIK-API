<?php

namespace Thunderlabid\Accounting\Traits\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\Accounting\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class DocStatusType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'DocStatus',
    ];

    public function fields()
    {
        return [
            'data'   => ['type' => Type::String()],
            'status' => ['type' => Type::String()],
        ] + $this->timestamp_fields() + $this->softdelete_fields(); 
    }

    protected function resolveDataAttribute($root, $args)
    {
        return is_array($root->data) ? json_encode($root->data)  : null;
    }

}