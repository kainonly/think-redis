<?php
declare (strict_types=1);

namespace think\redis\library;

use think\exception\InvalidArgumentException;
use think\redis\RedisModel;
use think\support\facade\Hash;

class RefreshToken extends RedisModel
{
    protected string $key = 'refresh-token:';

    /**
     * 生产刷新令牌
     * @param string $jti 令牌 ID
     * @param string $ack 确认码
     * @param int $expires 过期时间
     * @return string
     */
    public function factory(string $jti, string $ack, int $expires): string
    {
        return (string)$this->redis->setex($this->getKey($jti), $expires, Hash::create($ack));
    }

    /**
     * 续约刷新令牌
     * @param string $jti
     * @param int $expires
     */
    public function renewal(string $jti, int $expires): void
    {
        $this->redis->expire($this->getKey($jti), $expires);
    }

    /**
     * 验证刷新令牌
     * @param string $jti 令牌 ID
     * @param string $ack 确认码
     * @return bool
     */
    public function verify(string $jti, string $ack): bool
    {
        if (!$this->redis->exists($this->getKey($jti))) {
            return false;
        }

        return Hash::check($ack, $this->redis->get($this->getKey($jti)));
    }

    /**
     * 清除刷新令牌
     * @param string $jti
     * @param string $ack
     * @return bool
     */
    public function clear(string $jti, string $ack): bool
    {
        if (!$this->redis->exists($this->getKey($jti))) {
            return true;
        }

        if (!Hash::check($ack, $this->redis->get($this->getKey($jti)))) {
            return false;
        }

        return (bool)$this->redis->del([$this->getKey($jti)]);
    }
}