<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use DB;
use App\User;

class CheckToken extends Mutation
{
    protected $attributes = [
        'name' => 'CheckToken',
        'description' => 'A mutation'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::check();
    }

    public function type()
    {
        return Type::string();
    }

    public function args()
    {
        return [
            'username'  => ['type'  => Type::string(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'username'  => ['required', 'exists:' . app()->make(User::class)->getTable() . ',username'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with   = $fields->getRelations();

        $user   = User::where('username', $args['username'])->first();
        $token  = $user->tokens->where('expired_at', '>=', now());

        if(count($token)){
            return $token[0]['token'];
        }
        return 'NOT_AVAILABLE';
    }
}