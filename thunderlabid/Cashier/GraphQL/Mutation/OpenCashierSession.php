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

class OpenCashierSession extends Mutation
{
    protected $attributes = [
        'name' => 'OpenCashierSession',
        'description' => 'A mutation'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? CashierSession::find($args['id']) : app()->make(CashierSession::class)->fill($args)
                                );
    }

    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return [
            'balance' => ['type'  => Type::float(), 'description' => ''],
            'user_id' => ['type'  => Type::int(), 'description' => ''],
            'org_id'  => ['type'  => Type::int(), 'description' => ''],
            'department'  => ['type'  => Type::string(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'user_id'   => ['required', 'exists:' . app()->make(\App\User::class)->getTable() . ',id'],
            'org_id'    => ['required', 'exists:' . app()->make(\App\Org::class)->getTable() . ',id'],
            'balance'   => ['required', 'numeric'],
            'department'=> ['required', 'in:' . implode(',', config()->get('cashier.department'))],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $session    = CashierSession::create(['org_id' => $args['org_id'], 'department' => $args['department'], 'user_id' => $args['user_id'], 'opened_at' => now()]);
        // $balance    = CashierLog::create(['cashier_session_id' => $session->id, 'method' => 'CASH', 'amount' => $args['balance']]);

        return true;
    }
}