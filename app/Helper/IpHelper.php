<?php

namespace App\Helper;

/**
 * IP 处理助手类
 * @author daichongweb <daichongweb@foxmail.com>
 */
final class IpHelper
{
    /**
     * 获取国家
     */
    public static function getCountry()
    {
        $ip = self::getIp();
        if (self::isLan($ip)) {
            return '内网';
        }
        return self::getIpInfo($ip, 'country');
    }

    /**
     * 获取省份
     */
    public static function getRegion()
    {
        $ip = self::getIp();
        if (self::isLan($ip)) {
            return '内网';
        }
        return self::getIpInfo($ip, 'region');
    }

    /**
     * 获取城市
     */
    public static function getCity()
    {
        $ip = self::getIp();
        if (self::isLan($ip)) {
            return '内网';
        }
        return self::getIpInfo($ip, 'city');
    }

    /**
     * 获取运营商
     */
    public static function getISP()
    {
        $ip = self::getIp();
        if (self::isLan($ip)) {
            return '内网';
        }
        return self::getIpInfo($ip, 'isp');
    }

    /**
     * 根据ip获取城市信息
     */
    public static function getIpInfo(string $ip, string $field = '')
    {
        $url = "http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip;
        $ip = json_decode(file_get_contents($url));
        if ((string) $ip->code == '1') {
            return false;
        }
        $data = (array) $ip->data;
        return $field ? $data[$field] : $data;
    }

    /**
     * 获取IP
     */
    public static function getIp()
    {
        static $realip;
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } else if (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }
        return $realip;
    }

    /**
     * 判断内网
     */
    public static function isLan(string $ip)
    {
        $pattern = '/127.0.0.1|192.168.(.*)/';
        if (preg_match($pattern, $ip, $arr, PREG_OFFSET_CAPTURE)) {
            return true;
        }

        return false;
    }
}
