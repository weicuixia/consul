<?php

namespace PhpLib\Consul;

class ConsulResponse
{
    private $headers;
    private $body;
    private $status;

    /**
     * ConsulResponse constructor.
     * @param $headers
     * @param $body
     * @param int $status
     */
    public function __construct($headers, $body, $status = 200)
    {
        $this->headers = $headers;
        $this->body = $body;
        $this->status = $status;
    }

    /**
     * 获取头部信息
     *
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * 获取响应内容
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * 获取响应码
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->status;
    }

    /**
     * 转换格式
     *
     * @return mixed
     */
    public function json()
    {
        return json_decode($this->body, true);
    }
}