<?php

namespace lumen\bit\lifecycle;

interface GetCustom
{
    /**
     * Customize individual data returns
     * @param mixed $data
     * @return array
     */
    public function __getCustomReturn($data);
}