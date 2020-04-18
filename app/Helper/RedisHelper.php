<?php

namespace App\Helper;

use Illuminate\Support\Facades\Redis;

/**
 * redis 助手类
 * @author daichongweb <daichongweb@foxmail.com>
 */
final class RedisHelper
{
    const time = 86400;

    public static function setString(string $key, $value, int $time = RedisHelper::time)
    {
        return Redis::setex($key, $time, self::valueEn($value));
    }

    public static function getString(string $key)
    {
        $value = Redis::get($key);
        if (!$value) {
            return null;
        }
        return self::valueDe($value);
    }

    public static function delete(string $key)
    {
        return Redis::del($key);
    }

    public function setHash(string $key, array $value, int $time = RedisHelper::time)
    {
        Redis::hMset($key, $value);
        return Redis::expireAt($key, time() + $time);
    }

    public function getHash(string $key)
    {
        return Redis::hGetAll($key);
    }

    protected static function valueEn($value)
    {
        return serialize($value);
    }

    protected static function valueDe($value)
    {
        return unserialize(self::mb_unserialize($value));
    }


    protected static function mb_unserialize($str)
    {
        return preg_replace_callback('#s:(\d+):"(.*?)";#s', function ($match) {
            return 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
        }, $str);
    }
}
