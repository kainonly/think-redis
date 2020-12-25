<?php
declare (strict_types=1);

namespace think\redis;

use think\Service;

class RedisService extends Service
{
    public function register(): void
    {
        $this->app->bind('redis', function () {
            $options = $this->app->config->get('database.redis');
            return new RedisFactory($options);
        });
    }
}