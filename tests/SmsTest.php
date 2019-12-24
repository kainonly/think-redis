<?php
declare(strict_types=1);

namespace tests;

use Exception;
use think\redis\common\RedisFactory;
use think\redis\library\Sms;
use think\redis\service\RedisService;

class SmsTest extends BaseTest
{
    /**
     * @var Sms
     */
    private $model;

    /**
     * @var RedisFactory
     */
    private $redis;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $code;

    /**
     * 初始化
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(RedisService::class);
        $this->redis = $this->app->get('redis');
        $this->model = Sms::create();
        $this->phone = '155xxxxxxxx';
        $this->code = '1234';
    }

    public function testFactory()
    {
        $result = $this->model->factory($this->phone, $this->code);
        $this->assertEquals('OK', (string)$result);
    }

    public function testCheck()
    {
        try {
            $result = $this->model->check($this->phone, $this->code);
            $this->assertTrue($result);
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }

    public function testTime()
    {
        try {
            $data = $this->model->time($this->phone);
            $this->assertNotEmpty($data);
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }

    public function testCheckOnce()
    {
        try {
            $result = $this->model->check($this->phone, $this->code, true);
            $this->assertTrue($result);
            $exists = $this->redis->client()->exists('sms:' . $this->phone);
            $this->assertFalse((bool)$exists);
        } catch (Exception $e) {
            $this->expectErrorMessage($e->getMessage());
        }
    }
}