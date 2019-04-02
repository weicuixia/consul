<?php

namespace PhpLib\Consul;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use GuzzleHttp\Psr7\Response;

class Client
{
    /**
     * @var ClientInterface 初始化连接
     */
    private $client;

    /**
     * Client constructor.
     *
     * @param string $baseUri 服务器配置地址
     * @param HttpClientInterface|null $client
     */
    public function __construct(string $baseUri, HttpClientInterface $client = null)
    {
        if (empty($baseUri)) {
            $baseUri = 'http://127.0.0.1:8500';
        }
        $options = array_replace([
            'base_uri' => $baseUri,
            'http_errors' => false,
        ], []);

        $this->client = $client ? $client : new GuzzleClient($options);
    }

    /**
     * 获取consul配置
     *
     * @param string $url 配置路径
     * @param array $options 参数
     *
     * @return ConsulResponse 配置内容
     */
    public function get($url = null, array $options = array())
    {
        return $this->doRequest('GET', $url, $options);
    }

    /**
     * 删除consul配置
     *
     * @param string $url 配置路径
     * @param array $options
     *
     * @return ConsulResponse 配置内容
     */
    public function delete($url, array $options = array())
    {
        return $this->doRequest('DELETE', $url, $options);
    }

    /**
     * 增加consul配置
     *
     * @param string $url 配置路径
     * @param array $options 参数
     *
     * @return ConsulResponse 配置内容
     */
    public function put($url, array $options = array())
    {
        return $this->doRequest('PUT', $url, $options);
    }

    /**
     * 请求处理
     *
     * @param string $method 方法
     * @param string $url 连接
     * @param array $options 参数
     *
     * @return ConsulResponse 响应内容
     */
    private function doRequest($method, $url, $options)
    {
        if (isset($options['body']) && is_array($options['body'])) {
            $options['body'] = json_encode($options['body']);
        }
        try {
            $response = $this->client->request($method, $url, $options);
        } catch (Exception $e) {
            $message = sprintf('Something went wrong when calling consul (%s).', $e->getMessage());
            throw new RequestFailException($message);
        }

        if (400 <= $response->getStatusCode()) {
            $message = sprintf(
                'Something went wrong when calling consul (%s - %s).',
                $response->getStatusCode(),
                $response->getReasonPhrase()
            );
            $message .= "\n" . (string)$response->getBody();
            if (500 <= $response->getStatusCode()) {
                throw new RequestFailException($message, $response->getStatusCode());
            }
            throw new RequestFailException($message, $response->getStatusCode());
        }
        return new ConsulResponse($response->getHeaders(), (string)$response->getBody(), $response->getStatusCode());
    }
}