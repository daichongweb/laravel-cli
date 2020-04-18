<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 跨域处理 EnableCrossRequestMiddleware
 * @author daichongweb <daichongweb@foxmail.com>
 */
class EnableCrossRequestMiddleware
{

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $origin = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : '';
        // 允许跨域的域名配置
        $allow_origin = [
            env('DOMAIN_WEB'),
            env('DOMAIN_API'),
        ];
        if (in_array($origin, $allow_origin)) {
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN, TOKEN');
            $response->header('Access-Control-Expose-Headers', 'Authorization, authenticated');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS, DELETE');
            $response->header('Access-Control-Allow-Credentials', 'true');
        }
        return $response;
    }
}
