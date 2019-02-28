<?php

namespace lumen\bit\lifecycle;

interface AddBeforeHooks
{
    /**
     * Add pre-processing
     * @return boolean
     */
    public function __addBeforeHooks();
}