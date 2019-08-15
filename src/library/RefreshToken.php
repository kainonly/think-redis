<?php

namespace think\redis\library;

use think\bit\facade\Hash;
use think\redis\common\RedisModel;

final class RefreshToken extends RedisModel
{
    protected $key = 'refresh-token:';

    /**
     * 生产刷新令牌
     * @param string $jti 令牌 ID
     * @param string $ack 确认码
     * @param int $expires 过期时间
     * @return mixed
     */
    public function factory(string $jti,
                            string $ack,
                            int $expires)
    {
        return $this->redis->setex(
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
     */
    public function verify(string $jti,
                           string $ack)
    {
        if (!$this->redis->exists($this->key . $jti)) {
            return false;
        }

        return Hash::check(
            $ack,
            $this->redis->get($this->key . $jti)
        );
    }
}