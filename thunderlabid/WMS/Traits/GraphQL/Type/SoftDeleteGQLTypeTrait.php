<?php

namespace Thunderlabid\WMS\Traits\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL\GraphQL;

trait SoftDeleteGQLTypeTrait {

    public function softdelete_fields()
    {
        return [
            'deleted_at' => [
                'type'          => Type::string(),
                'description'   => '',
            ],
        ];
    }

    protected function resolveDeletedAtField($root, $args)
    {
        return $root->deleted_at ? $root->deleted_at->toDateTimeString() : null;
    }

}