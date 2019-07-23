<?php

namespace think\lists;

use think\Facade;

/**
 * Class Lists
 * @package think\lists
 * @method static BitLists data(array $lists)
 */
final class Lists extends Facade
{
    protected static function getFacadeClass()
    {
        return BitLists::class;
    }
}
