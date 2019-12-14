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

class CloseCashierSession extends Mutation
{
    protected $attributes = [
        'name' => 'CloseCashierSession',
        'description' => 'A mutation'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can('update', CashierSession::where('user_id', $args['user_id'])->wherenull('closed_at')->firstorfail());
    }

    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return [
            'user_id'           => ['type'  => Type::int(), 'description' => ''],
            'closing_balance'   => ['type'  => Type::float(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'user_id'           => ['required', 'exists:' . app()->make(\App\User::class)->getTable() . ',id'],
            'closing_balance'   => ['required', 'numeric'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $session    = CashierSession::wherenull('closed_at')->where('user_id', $args['user_id'])->firstorfail();
        $variance   = CashierLog::where('cashier_session_id', $session->id)->sum('amount');
        $session->closed_at = now();
        $session->closing_balance   = $args['closing_balance'];
        $session->variance          = $args['closing_balance'] - $variance;
        $session->save();

        return true;
    }
}