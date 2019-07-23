<?php

namespace think\lists\facade;

use think\lists\BitLists;
use think\Facade;

final class Lists extends Facade
{
    protected static function getFacadeClass()
    {
        return BitLists::class;
    }
}
