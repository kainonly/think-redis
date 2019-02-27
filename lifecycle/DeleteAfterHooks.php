<?php

namespace lumen\bit\lifecycle;

interface DeleteAfterHooks
{
    /**
     * Delete post processing
     * @return mixed
     */
    public function __deleteAfterHooks();
}