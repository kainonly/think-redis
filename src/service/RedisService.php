<?php

declare (strict_types=1);

namespace think\redis\service;

use Predis\Client;
use think\Service;

final class RedisService extends Service
{
    public function register()
    {
        $this->app->bind('redis', function () {
            $config = $this->app
                ->config
                ->get('database.redis.default');

            if (empty($config['password'])) {
                unset($config['password']);
            }

            return new Client($config);
        });
    }
}