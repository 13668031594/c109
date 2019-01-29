<?php

namespace App\Http\Middleware;

use App\Exceptions\JsonException;
use Closure;

class ApiMemberAct30
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

        if (is_null($member) || ($member->young_act != '30')) {

            $exception = [
                'status' => 'fails',
                'code' => '000',
                'message' => '该账号尚未激活',
            ];

            throw new JsonException(json_encode($exception));
        }

        return $next($request);
    }
}
