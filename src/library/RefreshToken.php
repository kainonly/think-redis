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
    public function factory(
        string $jti,
        string $ack,
        int $expires
    ): string
    {
        return (string)$this->redis->setex(
            $this->key . $jti,
            $expires,
            Hash::create($ack)
        );
    }

    /**
     * 验证刷新令牌
     * @param string $jti 令牌 ID
     * @param string $ack 确认码
     * @return bool
     * @throws InvalidArgumentException
     */
    public function verify(
        string $jti,
        string $ack
    ): bool
    {
        if (!$this->redis->exists($this->key . $jti)) {
            throw new InvalidArgumentException("令牌 [$jti] 不存在.");
        }

        return Hash::check(
            $ack,
            $this->redis->get($this->key . $jti)
        );
    }

    /**
     * 清除刷新令牌
     * @param string $jti
     * @param string $ack
     * @return bool
     */
    public function clear(
        string $jti,
        string $ack
    ): bool
    {
        if (!$this->redis->exists($this->key . $jti)) {
            return true;
        }

        if (!Hash::check($ack, $this->redis->get($this->key . $jti))) {
            return false;
        }

        return (bool)$this->redis->del([$this->key . $jti]);
    }
}