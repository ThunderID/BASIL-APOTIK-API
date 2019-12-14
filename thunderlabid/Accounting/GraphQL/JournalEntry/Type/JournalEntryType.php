<?php

namespace Thunderlabid\Accounting\GraphQL\JournalEntry\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\Accounting\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class JournalEntryType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'JournalEntry',
        // 'model'         => \Thunderlabid\Accounting\JournalEntry::class
    ];

    public function fields()
    {
        return [
            'id'        => ['type' => Type::nonNull(Type::int())],
            'org_id'    => ['type' => Type::int()],
            'no'        => ['type' => Type::string()],
            'date'      => ['type' => Type::string()],
            'ref_type'  => ['type' => Type::String()],
            'ref_id'    => ['type' => Type::Int()],
            'note'      => ['type' => Type::String()],
            'locked_at' => ['type' => Type::String()],
            'void_at'   => ['type' => Type::String()],

            /* RELATIONS */
            'lines'                 => ['type' => Type::listOf(GraphQL::type('JournalEntryLine'))],
        ] + $this->timestamp_fields() + $this->softdelete_fields(); 
    }

    protected function resolveDateField ($root, $args)  {
        return $root->date ? $root->date->toDateTimeString() : null;
    }

    protected function resolveLockedAtField ($root, $args)  {
        return $root->locked_at ? $root->locked_at->toDateTimeString() : null;
    }

    protected function resolveVoidAtField ($root, $args)  {
        return $root->void_at ? $root->void_at->toDateTimeString() : null;
    }

    protected function resolveLinesField($root, $args) {
        return $root->journal_entry_lines;
    }
}