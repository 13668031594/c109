<?php

namespace App\Http\Middleware;

use App\Exceptions\JsonException;
use App\Http\Classes\Set\SetClass;
use App\Http\Traits\TimeTrait;
use Closure;

class ApiWebClose
{
    use TimeTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $set_class = new SetClass();

        $set = $set_class->index();

        if ($set['webSwitch'] == 'off'){

            $exception = [
                'status' => 'fails',
                'code' => '969',
                'message' => $set['webCloseTxt'],
            ];

            throw new JsonException(json_encode($exception));
        }

        $open = $this->set_time($set['webOpenTime']);

        $close = $this->set_time($set['webCloseTime']);

        if ((time() < $open) || (time() > $close)) {

            $exception = [
                'status' => 'fails',
                'code' => '969',
                'message' => $set['webCloseReason'],
            ];

            throw new JsonException(json_encode($exception));
        }

        return $next($request);
    }
}
