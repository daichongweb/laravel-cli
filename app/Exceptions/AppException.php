<?php

namespace App\Exceptions;

/**
 * AppException 异常处理类 
 * @author daichongweb <daichongweb@foxmail.com>
 */
class AppException extends \Exception
{

    const HTTP_OK = 200;
    const HTTP_ERROR = 500;

    protected $data;
    protected $code;

    public function __construct($message, int $code = self::HTTP_ERROR, array $data = [])
    {
        $this->data = $data;
        $this->code = $code;
        parent::__construct($message, $code);
    }

    public function render()
    {
        $content = [
            'message'   => $this->message,
            'code'      => $this->code,
            'data'      => $this->data ?? [],
            'timestamp' => date('Y-m-d H:i:s')
        ];

        return response()->json($content, $this->code);
    }
}
