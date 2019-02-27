<?php

namespace think\bit\lifecycle;

interface DeletePrepHooks
{
    /**
     * Processing before the model is written after the transaction
     * @return mixed
     */
    public function __deletePrepHooks();
}