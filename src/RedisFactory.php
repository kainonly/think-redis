<?php
declare (strict_types=1);

namespace think\redis;

use Predis\Client;
use InvalidArgumentException;

class RedisFactory
{
    /**
     * 配置集合
     * @var array
     */
    private array $options;

    /**
     * 客户端集合
     * @var array
     */
    private array $clients = [];

    /**
     * RedisFactory constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * 创建 Redis 客户端
     * @param string $name 配置标识
     * @return Client
     */
    public function client(string $name = 'default'): Client
    {
        if (!empty($this->clients[$name])) {
            return $this->clients[$name];
        }
        if (empty($this->options[$name])) {
            throw new InvalidArgumentException("The [$name] does not exist.");
        }
        $option = $this->options[$name];
        if (empty($option['password'])) {
            unset($option['password']);
        }
        $this->clients[$name] = new Client($option);
        return $this->clients[$name];
    }
}