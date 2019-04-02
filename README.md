# 一、概述

consul 注册 & 发现服务 以及KV配置获取

# 二、目录
composer.json
    
```
    {
        "repositories": [
            {
                "url": "https://github.com/weicuixia/consul.git",
                "type": "git"
            }
        ],
        "require": {
            "weicuixia/consul": "^1.0"
        }
    }

    
```
执行命令：
    
```
    composer require weicuixia/consul
    
```
# 三、示例

```
// 编辑项目中的 bootstrap/app.php，注册 provider:
$app->register(\Weicuixia\Consul\ConsulServiceProvider::class);

Usage

The simple way to use this SDK, is to instantiate the service factory:

$factory = new Weicuixia\Consul\Factory();

Then, a service could be retrieve from this factory:

$kv = $factory->get(\Weicuixia\Consul\Services\KVInterface::class);

Then, a service expose few methods mapped from the consul API:

$kv->put('test/foo/bar', 'bazinga');
$kv->get('test/foo/bar', ['raw' => true]);
$kv->delete('test/foo/bar');
    
```

#### 配置ENV项:

```
1.在config/app.php文件中添加配置

'consul_kv_url' => env('CONSUL_KV_URL')

# .env 增加

# consul系统KV地址
CONSUL_KV_URL = http://10.60.34.238:8500
    
```

# 四、资料

WIKI文档和地址暂无~