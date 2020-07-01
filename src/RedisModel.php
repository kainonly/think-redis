<?php
declare (strict_types=1);

namespace think\redis;

use Predis\Client;
use Predis\Pipeline\Pipeline;
use Predis\Transaction\MultiExec;
use think\facade\Config;

/**
 * 缓存模型抽象类
 * Class RedisModel
 * @package think\redis
 */
abstract class RedisModel
{
    /**
     * 缓存模型键名
     * @var string
     */
    protected string $key;

    /**
     * Predis 操作类
     * @var Client|Pipeline|MultiExec
     */
    protected $redis;

    /**
     * Create RedisModel
     * @param Client|Pipeline|MultiExec $redis
     * @return static
     */
    public static function create($redis = null): RedisModel
    {
        return new static($redis);
    }

    /**
     * RedisModel constructor.
     * @param Client|Pipeline|MultiExec|null $redis
     */
    public function __construct($redis = null)
    {
        $this->redis = $redis ?? app('redis')->client('default');
    }

    /**
     * 获取键名
     * @return string
     */
    protected function getKey(): string
    {
        return Config::get('app.app_name') . ':' . $this->key;
    }
}