<?php

namespace lumen\bit\lifecycle;

interface AddAfterHooks
{
    /**
     * Add post processing
     * @param string|int $id
     * @return mixed
     */
    public function __addAfterHooks($id);
}