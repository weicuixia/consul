<?php

namespace Weicuixia\Consul\Services;

use Weicuixia\Consul\Client;
use Weicuixia\Consul\OptionsResolver;

class Health implements HealthInterface
{
    /**
     * @var Client 初始化连接
     */
    private $client;

    /**
     * Health constructor.
     *
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * 获取服务节点
     *
     * @param $node
     * @param array $options
     * @return \Weicuixia\Consul\ConsulResponse
     */
    public function node($node, array $options = array())
    {
        $params = [
            'query' => OptionsResolver::resolve($options, array('dc')),
        ];
        return $this->client->get('/v1/health/node/' . $node, $params);
    }

    /**
     * 检查心跳
     *
     * @param $service
     * @param array $options
     * @return \Weicuixia\Consul\ConsulResponse
     */
    public function checks($service, array $options = array())
    {
        $params = [
            'query' => OptionsResolver::resolve($options, array('dc')),
        ];
        return $this->client->get('/v1/health/checks/' . $service, $params);
    }

    /**
     * 获取服务信息
     *
     * @param $service
     * @param array $options
     * @return \Weicuixia\Consul\ConsulResponse
     */
    public function service($service, array $options = array())
    {
        $params = [
            'query' => OptionsResolver::resolve($options, array('dc', 'tag', 'passing')),
        ];
        return $this->client->get('/v1/health/service/' . $service, $params);
    }

    /**
     * 检查服务状态
     *
     * @param $state
     * @param array $options
     * @return \Weicuixia\Consul\ConsulResponse
     */
    public function state($state, array $options = array())
    {
        $params = [
            'query' => OptionsResolver::resolve($options, array('dc')),
        ];
        return $this->client->get('/v1/health/state/' . $state, $params);
    }
}