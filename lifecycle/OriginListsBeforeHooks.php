<?php

namespace think\bit\lifecycle;

interface OriginListsBeforeHooks
{
    /**
     * List data acquisition preprocessing
     * @return boolean
     */
    public function __originListsBeforeHooks();
}