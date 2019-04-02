<?php
/**
 * consul 获取配置示例
 * @package Weicuixia\Consul
 * @author katherine<weicuixiaoo@163.com>
 * @date 2019/02/19
 */


// 示例 http://10.60.34.238:8500/v1/kv/wos/test/elasticsearch
ConsulKvUtil::get('elasticsearch', ['raw' => true]);