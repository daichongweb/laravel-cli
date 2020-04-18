<?php

namespace App\Data\Admin;

use App\Helper\RedisHelper;

class MainData
{
    private static function key($id)
    {
        return 'user:' . $id;
    }

    public static function set($id)
    {
        return RedisHelper::setString(self::key($id), ['name' => '戴崇']);
    }

    public static function get($id)
    {
        return RedisHelper::getString(self::key($id));
    }
}
