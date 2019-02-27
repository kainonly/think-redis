<?php

namespace think\bit\lifecycle;

interface GetCustom
{
    /**
     * Customize individual data returns
     * @param array $data
     * @return array
     */
    public function __getCustomReturn(array $data);
}