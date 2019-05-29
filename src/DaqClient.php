<?php

namespace cmq\daq;

use cmq\sdk\CMQ;

final class DaqClient
{
    /**
     * 采集信息
     * @param string $namespace 命名空间
     * @param array $data 数据
     * @return array
     */
    public static function push(string $namespace, array $data = [])
    {
        try {
            $res = CMQ::Queue()->SendMessage(config('cmq.daq'), [
                'namespace' => $namespace,
                'data' => $data
            ]);
            return [
                'error' => (int)($res['code'] != 0),
                'msg' => $res['message']
            ];
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'msg' => $e->getMessage()
            ];
        }
    }
}
