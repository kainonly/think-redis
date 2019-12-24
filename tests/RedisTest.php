<?php
declare(strict_types=1);

namespace tests;

use think\redis\common\RedisFactory;
use think\redis\service\RedisService;

class RedisTest extends BaseTest
{
    /**
     * @var RedisFactory
     */
    private $redis;
    /**
     * @var string
     */
    private $key = 'test:default';
    /**
     * @var string
     */
    private $value = 'default';

    /**
     * 初始化
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(RedisService::class);
        $this->redis = $this->app->get('redis');
    }

    public function testRedisSetValue()
    {
        $result = $this->redis->client('default')
            ->set($this->key, $this->value);
        $this->assertEquals('OK', (string)$result);
    }

    public function testRedisGetValue()
    {
        $data = $this->redis->client('default')
            ->get($this->key);
        $this->assertEquals($this->value, $data);
    }

    public function testRedisDeleteValue()
    {
        $result = $this->redis->client('default')
            ->del([$this->key]);
        $this->assertEquals(1, $result);
    }
}