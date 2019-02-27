<?php

namespace lumen\bit\lifecycle;

interface EditBeforeHooks
{
    /**
     * Modify preprocessing
     * @return boolean
     */
    public function __editBeforeHooks();
}