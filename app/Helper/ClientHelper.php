<?php

namespace App\Helper;

/**
 * 获取请求参数 ClientHelper
 * @author daichongweb <daichongweb@foxmail.com>
 */
final class ClientHelper
{

    public static function getIp()
    {
        return \Illuminate\Support\Facades\Request::server("REMOTE_ADDR");
    }

    public static function getAgent()
    {
        return \Illuminate\Support\Facades\Request::header("user-agent");
    }

    public static function getToken()
    {
        return \Illuminate\Support\Facades\Request::header("TOKEN");
    }

    const plantFormIos = "ios";
    const plantFormAndroid = "android";
    public static function getPlantForm()
    {
        $agent = self::getAgent();
        if (strpos($agent, 'iPhone') || strpos($agent, 'iPad')) {
            return self::plantFormIos;
        } else if (strpos($agent, 'Android')) {
            return self::plantFormAndroid;
        }
        return NULL;
    }

    public static function getLocation()
    {
        $long = \Illuminate\Support\Facades\Request::header("X-YFG-LONGI");
        $lati = \Illuminate\Support\Facades\Request::header("X-YFG-LATI");
        $result = [];
        if ($long) {
            $result['long'] = $long;
        }
        if ($lati) {
            $result['lati'] = $lati;
        }
        return $result;
    }
}
