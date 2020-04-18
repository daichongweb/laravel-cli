<?php

namespace App\Helper;

/**
 * 请求返回类 AjaxHelper
 * @author daichongweb <daichongweb@foxmail.com>
 */
final class AjaxHelper
{

    public static function success(string $message = '', $data = [])
    {
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function error(string $message = '')
    {
        return response()->json([
            'code' => 500,
            'status' => 'error',
            'message' => $message
        ]);
    }
}
