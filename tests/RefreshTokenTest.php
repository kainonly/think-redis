<?php
declare(strict_types=1);

namespace RedisTests;

use Exception;
use think\extra\service\HashService;
use think\redis\library\RefreshToken;
use think\redis\service\RedisService;

class RefreshTokenTest extends BaseTest
{
    /**
     * @var RefreshToken
     */
    private RefreshToken $model;

    /**
     * @var string
     */
    private string $jti;

    /**
     * @var string
     */
    private string $ack;

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

    public function testFactory(): void
    {
        $this->app->register(HashService::class);
        $result = $this->model->factory($this->jti, $this->ack, 60);
        self::assertEquals('OK', $result);
    }

    public function testVerify(): void
    {
        try {
            $this->app->register(HashService::class);
            $result = $this->model->verify($this->jti, $this->ack);
            self::assertTrue($result);
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }

    public function testClear(): void
    {
        $result = $this->model->clear($this->jti, $this->ack);
        self::assertTrue($result);
    }
}