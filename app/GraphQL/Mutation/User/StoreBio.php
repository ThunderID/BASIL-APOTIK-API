<?php

namespace App\GraphQL\Mutation\User;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use App\User;
use App\Bio;

class StoreBio extends Mutation
{
    protected $attributes = [
        'name' => 'StoreBio',
        'description' => 'A mutation'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Bio::find($args['id']) : app()->make(Bio::class)->fill($args)
                                );
    }

    public function type()
    {
        return GraphQL::type('Bio');
    }

    public function args()
    {
        return [
            'user_id'       => ['type'  => Type::Int(), 'description' => ''],
            'name'          => ['type'  => Type::String(), 'description' => ''],
            'phone'         => ['type'  => Type::String(), 'description' => ''],
            'birthdate'     => ['type'  => Type::String(), 'description' => ''],
            'pin'           => ['type'  => Type::String(), 'description' => ''],
            'title'         => ['type'  => Type::String(), 'description' => 'MR/MRS/MS'],
            'passport'      => ['type'  => Type::String(), 'description' => ''],
            'address'       => ['type'  => Type::String(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'user_id'      => ['nullable', 'exists:' . app()->make(\App\User::class)->getTable() . ',id'],
            'name'         => ['required', 'string'],
            'phone'        => ['required', 'string'],
            'birthdate'    => ['required', 'date'],
            'pin'          => ['nullable', 'string'],
            'title'        => ['nullable', 'string', 'in:MR,MRS,MS'],
            'passport'     => ['nullable', 'string'],
            'address'      => ['nullable', 'string'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with   = $fields->getRelations();

        $bio    = isset($args['user_id']) ? \App\Bio::firstornew(['user_id' => $args['user_id']]) : new \App\Bio;
        $bio->fill($args);
        $bio->save();

        return $bio;
    }
}