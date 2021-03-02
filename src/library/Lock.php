<?php
declare (strict_types=1);

namespace think\redis\library;

use think\redis\RedisModel;

class Lock extends RedisModel
{
    protected string $key = 'lock:';

    /**
     * 锁定清零
     * @param string $name
     */
    public function remove(string $name): void
    {
        $this->redis->del($this->getKey($name));
    }

    /**
     * 锁定验证
     * @param string $name
     * @param int $limit
     * @return bool
     */
    public function check(string $name, int $limit = 5): bool
    {
        if (!$this->redis->exists($this->getKey($name))) {
            return true;
        }
        return $this->redis->get($this->getKey($name)) < $limit;
    }

    /**
     * 锁定自增
     * @param string $name
     */
    public function inc(string $name): void
    {
        $this->redis->incr($this->getKey($name));
        $this->lock($name);
    }

    /**
     * 锁定延续
     * @param string $name
     * @param int $renew
     */
    public function lock(string $name, int $renew = 900): void
    {
        $this->redis->expire($this->getKey($name), $renew);
    }
}