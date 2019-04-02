<?php
/**
 * consul KV 配置
 * @package App\Utils
 * @author katherine<weicuixiaoo@163.com>
 * @date 2019/03/30
 */

namespace App\Utils;

use Weicuixia\Consul\Factory;
use Weicuixia\Consul\KV\KVInterface;

class ConsulKvUtil
{
    /**
     * @var string $common 公共配置目录（不区分环境）
     */
    protected static $common = 'common';

    /**
     * @var string 项目目录
     */
    protected static $project = 'wos';

    /**
     * 根据环境获取对应配置
     *
     * @param string $url 路径地址
     * @param string $dirName 初始目录
     *
     * @return string|mixed 配置内容
     */
    public static function initialize(string $url, $dirName = '')
    {
        // 获取工厂模式初始化类
        $factory = new Factory(config('app.consul_kv_url'));
        $kv = $factory->getService(KVInterface::class);

        $env = config('app.env');
        // 如果没有设置初始目录，则默认取配置环境目录
        $dirName = !empty($dirName) ? $dirName : $env;
        
        $response = $kv->get(sprintf('%s/%s/%s', self::$project, $dirName, $url), ['raw' => true]);
        return !empty($response->getBody()) ? $response->getBody() : null;
    }

    /**
     * 获取指定目录配置 （区分环境）
     *
     * @param string $url 配置路径
     *
     * @return mixed|string 配置内容
     */
    public static function get(string $url)
    {
        return self::initialize($url);
    }

    /**
     * 获取公共配置（不区分环境）
     *
     * @param string $url 路径地址
     *
     * @return string|mixed 配置内容
     */
    public static function getCommonConfig(string $url)
    {
        return self::getKvConfig($url, self::$common);
    }


}
