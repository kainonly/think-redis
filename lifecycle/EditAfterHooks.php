<?php

namespace lumen\bit\lifecycle;

interface EditAfterHooks
{
    /**
     * Modify post processing
     * @return mixed
     */
    public function __editAfterHooks();
}