<?php
namespace PhpLib\Consul\Services;

use PhpLib\Consul\Client;
use PhpLib\Consul\OptionsResolver;

class KV implements KVInterface
{
    /**
     * @var Client 初始化连接
     */
    private $client;

    /**
     * KV constructor.
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * 获取consul kv配置
     *
     * @param string $key key值
     * @param array $options 参数
     *
     * @return mixed 配置内容
     */
    public function get($key, array $options = array())
    {
        $params = [
            'query' => OptionsResolver::resolve($options, array('dc', 'recurse', 'keys', 'separator', 'raw', 'stale', 'consistent', 'default')),
        ];
        return $this->client->get('v1/kv/'.$key, $params);
    }

    /**
     * 增加consul kv配置
     *
     * @param string $key key值
     * @param mixed $value 值内容
     * @param array $options 参数
     *
     * @return mixed 配置内容
     */
    public function put($key, $value, array $options = array())
    {
        $params = [
            'body' => (string) $value,
            'query' => OptionsResolver::resolve($options, array('dc', 'flags', 'cas', 'acquire', 'release')),
        ];
        return $this->client->put('v1/kv/'.$key, $params);
    }

    /**
     * 删除consul kv配置
     * @param string $key key值
     * @param array $options 参数
     *
     * @return mixed 配置内容
     */
    public function delete($key, array $options = array())
    {
        $params = [
            'query' => OptionsResolver::resolve($options, array('dc', 'recurse')),
        ];
        return $this->client->delete('v1/kv/'.$key, $params);
    }
}