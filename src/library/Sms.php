<?php
declare (strict_types=1);

namespace think\redis\library;

use think\exception\InvalidArgumentException;
use think\redis\RedisModel;

class Sms extends RedisModel
{
    protected string $key = 'sms:';

    /**
     * 生成手机验证缓存
     * @param string $phone 手机号
     * @param string $code 验证码
     * @param int $timeout 有效时间，默认120秒
     * @return string
     */
    public function factory(string $phone, string $code, int $timeout = 120): string
    {
        /**
         * publish_time 发布时间
         * timeout 有效时间
         */
        $data = json_encode([
            'code' => $code,
            'publish_time' => time(),
            'timeout' => $timeout
        ]);

        return (string)$this->redis->setex($this->key . $phone, $timeout, $data);
    }

    /**
     * 验证手机验证码
     * @param string $phone 手机号
     * @param string $code 验证码
     * @param boolean $once 验证仅一次有效，验证完成即不存在
     * @return bool
     * @throws InvalidArgumentException
     */
    public function check(string $phone, string $code, bool $once = false): bool
    {
        if (!$this->redis->exists($this->key . $phone)) {
            throw new InvalidArgumentException("手机号 [$phone] 验证不存在.");
        }

        $data = json_decode($this->redis->get($this->key . $phone), true);
        $result = ($code === $data['code']);
        if ($once && $result) {
            $this->redis->del([
                $this->key . $phone
            ]);
        }

        return $result;
    }

    /**
     * 获取验证时间信息
     * @param string $phone 手机号
     * @return array
     * @throws InvalidArgumentException
     */
    public function time(string $phone): array
    {
        if (!$this->redis->exists($this->key . $phone)) {
            throw new InvalidArgumentException("手机号 [$phone] 验证不存在.");
        }

        $data = json_decode($this->redis->get($this->key . $phone), true);

        /**
         * publish_time 发布时间
         * timeout 有效时间
         */
        return [
            'publish_time' => $data['publish_time'],
            'timeout' => $data['timeout']
        ];
    }
}
