<?php

namespace App\Helper;

use DateTime;
use OSS\Core\OssException;
use OSS\OssClient;

/**
 * Oss 对象存储类
 * @author daichongweb <daichongweb@foxmail.com>
 * @before 使用前需安装oss扩展
 */
final class Oss
{
    private static $accessKeyId = '';

    private static $accessKeySecret = '';

    private static $endpoint = "";

    private static $bucket = '';

    private static $instance;

    public static function ossClient()
    {
        if (null === static::$instance) {
            static::$instance = new OssClient(self::$accessKeyId, self::$accessKeySecret, self::$endpoint);
        }
        return static::$instance;
    }

    /**
     * @param     string       $object   文件名
     * @param     string       $filePath  文件地址
     */
    public static function ossUpload($object, $filePath)
    {
        try {
            return self::$instance->uploadFile(self::$bucket, $object, $filePath);
        } catch (OssException $e) {
            return FunctionHelper::error($e->getMessage());
        }
    }

    private static function gmtIso8601($time)
    {
        $dtStr = date("c", $time);
        $mydatetime = new DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration . "Z";
    }

    /**
     * 获取签名
     */
    public static function policy()
    {
        $id = Config('oss.accessKeyId'); // oss accessKeyId
        $key = Config('oss.accessKeySecret'); // oss accessKeySecret
        $host = Config('oss.endpoint'); // oss 上传地址
        $callbackUrl = Config('oss.callbackUrl'); // 回调地址 这个可以忽略
        $dir =  Config('oss.dir'); // 存放的文件夹

        $callback_param = array(
            'callbackUrl' => $callbackUrl,
            'callbackBody' => 'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}',
            'callbackBodyType' => "application/x-www-form-urlencoded"
        );
        $callback_string = json_encode($callback_param);
        $base64_callback_body = base64_encode($callback_string);
        $now = time();
        $expire = 30;
        $end = $now + $expire;
        $expiration = self::gmtIso8601($end);

        $condition = array(0 => 'content-length-range', 1 => 0, 2 => 1048576000);
        $conditions[] = $condition;

        $start = array(0 => 'starts-with', 1 => '$key', 2 => $dir);
        $conditions[] = $start;


        $arr = array('expiration' => $expiration, 'conditions' => $conditions);
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        $response['callback'] = $base64_callback_body;
        $response['dir'] = $dir;
        return $response;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}
