<?php

namespace App\GraphQL;

use GraphQL\Error\Debug;
use GraphQL\Error\Error;
use Rebing\GraphQL\Error\AuthorizationError;
use Rebing\GraphQL\Error\ValidationError;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Schema;
use GraphQL\Error\FormattedError;
use GraphQL\Type\Definition\ObjectType;
use Rebing\GraphQL\Exception\SchemaNotFound;
use Rebing\GraphQL\Support\PaginationType;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Validation\ValidationException;
use App\Exceptions\PolicyException;
use Str; 
use Illuminate\Support\MessageBag;

class GQLErrorFormatter
{
    public static function formatError(Error $e = null)
    {
        $debug = config('app.debug') ? (Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE) : 0;
        $formatter = FormattedError::prepareFormatter(null, $debug);
        $error = $formatter($e);

        $previous = $e->getPrevious();
        if($previous && $previous instanceof ValidationError)
        {
            $error['validation'] = $previous->getValidatorMessages();
        }
        elseif ($previous instanceof \Illuminate\Validation\ValidationException)
        {
            $error['message'] = 'validation';
            $error['validation'] = $previous->errors();
        }
        elseif ($previous instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)
        {
            $error['message'] = 'validation';
            $error['validation'] =  [
                                        'id' => ['notfound']
                                    ];
        }
        elseif ($previous instanceof PolicyException) {
            $error['message'] = $e->getMessage();
        }
        else
        {
            if (config('app.debug'))
            {
                throw $e;
            }
        }

        if (isset($error['validation']) && $error['validation'] instanceOf MessageBag)
        {
            $error['validation'] = $error['validation']->toArray();
            foreach ($error['validation'] as $k => $v)
            {
                if (Str::is('input.*', $k)) {
                    $error['validation'][str_replace('input.', '', $k)] = $v;
                    unset($error['validation'][$k]);
                }
            }
        }
        
        if (!config('app.debug')) {
            unset($error['locations']);
            unset($error['extensions']);
            unset($error['path']);
        }
        unset($error['trace']);

        return $error;
    }

}