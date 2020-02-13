<?php
declare(strict_types=1);

namespace RedisTests;

use Exception;
use Tests\BaseTest;
use think\extra\service\HashService;
use think\redis\library\RefreshToken;
use think\redis\service\RedisService;

class RefreshTokenTest extends BaseTest
{
    /**
     * @var RefreshToken
     */
    private $model;

    /**
     * @var string
     */
    private $jti;

    /**
     * @var string
     */
    private $ack;

    /**
     * 初始化
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(RedisService::class);
        $this->model = RefreshToken::create();
        $this->jti = 'test';
        $this->ack = md5('test');
    }

    public function testFactory()
    {
        $this->app->register(HashService::class);
        $result = $this->model->factory($this->jti, $this->ack, 60);
        $this->assertEquals('OK', (string)$result);
    }

    public function testVerify()
    {
        try {
            $this->app->register(HashService::class);
            $result = $this->model->verify($this->jti, $this->ack);
            $this->assertTrue($result);
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }

    public function testClear()
    {
        $result = $this->model->clear($this->jti, $this->ack);
        $this->assertTrue($result);
    }
}