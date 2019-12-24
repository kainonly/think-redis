<?php
declare (strict_types=1);

namespace think\redis\service;

use think\Service;
use think\redis\common\RedisFactory;

class RedisService extends Service
{
    public function register()
    {
        $this->app->bind('redis', function () {
            $options = $this->app->config
                ->get('database.redis');

            return new RedisFactory($options);
        });
    }
}