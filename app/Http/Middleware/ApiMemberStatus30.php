<?php

namespace App\Http\Middleware;

use App\Exceptions\JsonException;
use Closure;

class ApiMemberStatus30
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $member = auth('api')->user() ?? auth('web')->user();

        if (is_null($member) || ($member->young_status == '30')) {

            $exception = [
                'status' => 'fails',
                'code' => '696',
                'message' => '该账号已被封停，无法执行该操作',
            ];

            throw new JsonException(json_encode($exception));
        }

        return $next($request);
    }
}
