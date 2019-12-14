<?php

namespace Thunderlabid\POS\Traits\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL\GraphQL;

trait HasUUIDGQLTypeTrait {

    protected function resolveIdField($root, $args)
    {
        return $root->id ? $root->id : $root->id;
    }

}