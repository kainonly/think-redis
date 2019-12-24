<?php
declare(strict_types=1);

namespace tests;

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
        $this->model = RefreshToken::create($this->app->get('redis'));
        $this->jti = 'test';
        $this->ack = rand(0, 1000);
    }

    public function testFactory()
    {
        $this->model->factory('test', '1', 60);
    }
}