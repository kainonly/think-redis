<?php

namespace lumen\bit\lifecycle;

interface DeleteBeforeHooks
{
    /**
     * Delete pre-processing
     * @return boolean
     */
    public function __deleteBeforeHooks();
}