<?php

namespace App\Exceptions;

use Exception;

class BusinessException extends Exception
{
    protected $statusCode=500;
    /**
     * 业务异常构造函数
     * @param array $codeResponse 状态码
     * @param string $info 自定义返回信息，不为空时会替换掉codeResponse 里面的message文字信息
     */
    public function __construct(array $codeResponse, $info = '',$statusCode=500)
    {
        [$code, $message] = $codeResponse;
        parent::__construct($info ?: $message, $code);
    }
    public function render() {
        return response()->json([
            'status'  => 'fail',
            'code'    => $this->code,
            'message' => $this->message,
            'data'    => null,
            'error'  => $this->getFile().$this->getLine()
        ])->setStatusCode($this->statusCode);
    }
}
