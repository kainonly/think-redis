<?php
declare(strict_types=1);

namespace RedisTests;

use think\redis\RedisFactory;
use think\redis\RedisService;

class RedisTest extends BaseTest
{
    /**
     * @var RedisFactory
     */
    private $redis;
    /**
     * @var string
     */
    private string $key = 'test:default';
    /**
     * @var string
     */
    private string $value = 'default';

    /**
     * 初始化
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(RedisService::class);
        $this->redis = $this->app->get('redis');
    }

    public function testRedisSetValue(): void
    {
        $result = $this->redis->client('default')->set($this->key, $this->value);
        self::assertEquals('OK', (string)$result);
    }

    public function testRedisGetValue(): void
    {
        $data = $this->redis->client('default')->get($this->key);
        self::assertEquals($this->value, $data);
    }

    public function testRedisDeleteValue(): void
    {
        $result = $this->redis->client('default')->del([$this->key]);
        self::assertEquals(1, $result);
    }
}