# cmq-daq-sdk

CMQ 队列采集数据

#### 配置

进入腾讯云 **消息服务CMQ -> 队列服务 -> 队列** 中创建采集数据的队列（名称自定义），在 `cmq.php` 配置文件加入采集配置

```php
return [
    ...
    'daq' => 'daq-service'
    ...
];
```

- **daq** 采集队列名称

#### push(string $namespace, array $data = [])

推送采集数据

- **namespace** `string` 采集命名空间
- **data** `array` 采集数据

```php
return DaqClient::push('test', [
    'name' => 'kain',
    'time' => time()
]);
```
