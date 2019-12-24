<?php
declare (strict_types=1);

namespace think\redis;

use Predis\Client;
use Predis\Pipeline\Pipeline;
use Predis\Transaction\MultiExec;

/**
 * 缓存模型抽象类
 * Class RedisModel
 * @package think\redis\common
 */
abstract class RedisModel
{
    /**
     * 缓存模型键值
     * @var string
     */
    protected $key;

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
        $this->redis = !empty($redis) ? $redis : app('redis')->client('default');
    }
}