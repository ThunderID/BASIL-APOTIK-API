<?php

namespace Thunderlabid\Accounting\GraphQL\JournalEntry\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;

use Thunderlabid\Accounting\Traits\GraphQL\Type\SoftDeleteGQLTypeTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Type\TimestampGQLTypeTrait;
use Thunderlabid\Accounting\Traits\GraphQL\Type\HasUUIDGQLTypeTrait;

class IJournalEntryLineType extends GraphQLType {

    use SoftDeleteGQLTypeTrait;
    use TimestampGQLTypeTrait;
    use HasUUIDGQLTypeTrait;

    protected $attributes = [
        'name'          => 'IJournalEntryLine',
        'description'   => '',
        'model'         => \Thunderlabid\Accounting\JournalEntryLine::class,
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'coa_id'            => ['type' => Type::Int(), 'rules' => ['required']],
            'subsidiary_coa_id' => ['type' => Type::Int(), 'rules' => ['required']],
            'amount'            => ['type' => Type::Float(), 'rules' => ['required', 'numeric']],
            
        ];
    }

}