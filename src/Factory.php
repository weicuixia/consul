<?php

namespace PhpLib\Consul;

use GuzzleHttp\Client as GuzzleClient;
use PhpLib\Consul\Services\Health;
use PhpLib\Consul\Services\HealthInterface;
use PhpLib\Consul\Services\KV;
use PhpLib\Consul\Services\KVInterface;

class Factory
{
    /**
     * @var array 服务类配置
     */
    private static $services = [
        KVInterface::class => KV::class,
        HealthInterface::class => Health::class,
        // for backward compatibility:
        KVInterface::SERVICE_NAME => KV::class,
        HealthInterface::SERVICE_NAME => Health::class,
    ];

    /**
     * @var Client 初始化连接
     */
    private $client;


    /**
     * ServiceFactory constructor.
     *
     * @param string $baseUri 初始化服务地址
     * @param GuzzleClient|null $guzzleClient
     */
    public function __construct(string $baseUri, GuzzleClient $guzzleClient = null)
    {
        $this->client = new Client($baseUri, $guzzleClient);
    }


    /**
     * 根据类名获取类的实例化
     *
     * @param mixed $service 使用类名
     *
     * @return mixed
     */
    public function getService($service)
    {
        if (!array_key_exists($service, self::$services)) {
            throw new RequestFailException(sprintf(
                'The service "%s" is not available. Pick one among "%s".',
                $service,
                implode('", "', array_keys(self::$services))
            ));
        }

        if (isset(self::$services[$service])) {
            $class = self::$services[$service];
            return new $class($this->client);
        }

        return null;
    }
}