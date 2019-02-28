<?php

namespace lumen\bit\traits;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Trait GetModel
 * @package lumen\bit\traits
 * @property string model
 * @property array post
 * @property array get_validate
 * @property array get_before_result
 * @property array get_condition
 * @property array get_select
 */
trait GetModel
{
    public function get()
    {
        $validator = Validator::make($this->post, $this->get_validate);
        if ($validator->fails()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

        if (method_exists($this, '__getBeforeHooks') &&
            !$this->__getBeforeHooks()) {
            return $this->get_before_result;
        }

        try {
            $condition = $this->get_condition;
            if (isset($this->post['id']) &&
                !empty($this->post['id'])) array_push(
                $condition,
                ['id', '=', $this->post['id']]
            );

            if (isset($this->post['where']) &&
                !empty($this->post['where'])) $condition = array_merge(
                $condition,
                $this->post['where']
            );

            $data = Db::table($this->model)
                ->where($condition)
                ->first($this->get_select);

            return method_exists($this, '__getCustomReturn') ? $this->__getCustomReturn($data) : [
                'error' => 0,
                'data' => $data
            ];
        } catch (QueryException $e) {
            return [
                'error' => 1,
                'msg' => $e->errorInfo
            ];
        }
    }
}