<?php
declare (strict_types=1);

namespace think\redis\library;

use think\redis\RedisModel;

class UserLock extends RedisModel
{
    protected string $key = 'user-lock:';

    /**
     * 锁定用户清零
     * @param string $username
     */
    public function remove(string $username): void
    {
        $this->redis->del($this->getKey($username));
    }

    /**
     * 锁定验证
     * @param string $username
     * @return bool
     */
    public function check(string $username): bool
    {
        if (!$this->redis->exists($this->getKey($username))) {
            return true;
        }
        return $this->redis->get($this->getKey($username)) < 5;
    }

    /**
     * 锁定自增
     * @param string $username
     */
    public function inc(string $username): void
    {
        $this->redis->incr($this->getKey($username));
        $this->lock($username);
    }

    /**
     * 锁定延续
     * @param string $username
     */
    public function lock(string $username): void
    {
        $this->redis->expire($this->getKey($username), 900);
    }
}