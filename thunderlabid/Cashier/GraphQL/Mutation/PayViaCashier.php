<?php

namespace Thunderlabid\Cashier\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use Thunderlabid\Cashier\CashierSession;
use Thunderlabid\Cashier\CashierLog;

class PayViaCashier extends Mutation
{
    protected $attributes = [
        'name' => 'PayViaCashier',
        'description' => 'A mutation'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? CashierLog::find($args['id']) : app()->make(CashierLog::class)->fill($args)
                                );
    }

    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return [
            'amount'    => ['type'  => Type::float(), 'description' => ''],
            'ref_id'    => ['type'  => Type::int(), 'description' => ''],
            'ref_type'  => ['type'  => Type::string(), 'description' => ''],
            'method'    => ['type'  => Type::string(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'amount'  => ['required', 'numeric'],
            'ref_id'  => ['required', 'integer'],
            'method'  => ['required', 'in:'.implode(',', config()->get('cashier.settlement_method'))],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select     = $fields->getSelect();
        $with       = $fields->getRelations();

        $session    = CashierSession::wherenull('closed_at')->where('user_id', Auth::user()->id)->firstorfail();
        $balance    = CashierLog::create(['cashier_session_id' => $session->id, 'ref_id' => $args['ref_id'], 'ref_type' => $args['ref_type'], 'method' => $args['method'], 'amount' => $args['amount']]);

        return true;
    }
}