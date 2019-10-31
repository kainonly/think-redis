<?php
declare(strict_types=1);

namespace testing;

use PHPUnit\Framework\TestCase;
use Predis\Client;
use think\App;
use think\redis\service\RedisService;

class RedisTest extends TestCase
{
    /**
     * @return App
     */
    public function testNewApp()
    {
        $app = new App();
        $app->initialize();
        $this->assertInstanceOf(
            App::class,
            $app,
            '应用容器创建失败'
        );
        return $app;
    }

    /**
     * @param App $app
     * @return object
     * @depends testNewApp
     */
    public function testRegisterService(App $app)
    {
        $app->register(RedisService::class);
        $redis = $app->get('redis');
        $this->assertInstanceOf(
            Client::class,
            $redis,
            '服务注册失败'
        );
        return $redis;
    }

    /**
     * @param Client $redis
     * @depends testRegisterService
     */
    public function testSet(Client $redis)
    {
        $redis->set('name', 'kain');
        $this->assertEquals(
            'kain',
            $redis->get('name'),
            'PRedis 客户端执行失败'
        );
    }
}