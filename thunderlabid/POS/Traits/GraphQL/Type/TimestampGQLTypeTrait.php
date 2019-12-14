<?php

namespace Thunderlabid\POS\Traits\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL\GraphQL;

trait TimestampGQLTypeTrait {

    public function timestamp_fields()
    {
        return [
            'created_at' => [
                'type'          => Type::string(),
                'description'   => '',
            ],
            'updated_at' => [
                'type'          => Type::string(),
                'description'   => '',
            ],
        ];
    }

    protected function resolveCreatedAtField($root, $args)
    {
        return $root->created_at->toDateTimeString();
    }

    protected function resolveUpdatedAtField($root, $args)
    {
        return $root->updated_at->toDateTimeString();
    }

}