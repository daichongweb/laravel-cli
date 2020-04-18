<?php

namespace App\Http\Middleware\Web;

use App\Exceptions\AppException;
use Closure;
use App\Helper\ClientHelper;

/**
 * web端中间件 AuthMiddleware
 */
class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = ClientHelper::getToken();
        if (!$token) {
            throw new AppException('请先登录', 401);
        }
        return $next($request);
    }
}
