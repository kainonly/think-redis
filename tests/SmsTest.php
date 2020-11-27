<?php
declare(strict_types=1);

namespace RedisTests;

use Exception;
use think\redis\common\RedisFactory;
use think\redis\library\Sms;
use think\redis\service\RedisService;

class SmsTest extends BaseTest
{
    /**
     * @var Sms
     */
    private Sms $model;

    /**
     * @var RedisFactory
     */
    private RedisFactory $redis;

    /**
     * @var string
     */
    private string $phone;

    /**
     * @var string
     */
    private string $code;

    /**
     * 初始化
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(RedisService::class);
        $redis = $this->app->get('redis');
        assert($redis instanceof RedisFactory);
        $this->redis = $redis;
        $this->model = Sms::create();
        $this->phone = '155xxxxxxxx';
        $this->code = '1234';
    }

    public function testFactory(): void
    {
        $result = $this->model->factory($this->phone, $this->code);
        self::assertEquals('OK', (string)$result);
    }

    public function testCheck(): void
    {
        try {
            $result = $this->model->check($this->phone, $this->code);
            self::assertTrue($result);
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }

    public function testTime(): void
    {
        try {
            $data = $this->model->time($this->phone);
            self::assertNotEmpty($data);
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }

    public function testCheckOnce(): void
    {
        try {
            $result = $this->model->check($this->phone, $this->code, true);
            self::assertTrue($result);
            $exists = $this->redis->client()->exists('sms:' . $this->phone);
            self::assertFalse((bool)$exists);
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }
}