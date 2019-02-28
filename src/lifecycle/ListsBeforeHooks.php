<?php

namespace lumen\bit\lifecycle;

interface ListsBeforeHooks
{
    /**
     * Paging data acquisition preprocessing
     * @return boolean
     */
    public function __listsBeforeHooks();
}