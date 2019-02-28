<?php

namespace lumen\bit\traits;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Trait ListsModel
 * @package lumen\bit\traits
 * @property string model
 * @property array post
 * @property array origin_lists_validate
 * @property array origin_lists_before_result
 * @property array origin_lists_condition
 * @property string origin_lists_order_columns
 * @property string origin_lists_order_direct
 * @property array origin_lists_columns
 */
trait OriginListsModel
{
    public function originLists()
    {
        $validator = Validator::make($this->post, array_merge($this->origin_lists_validate, [
            'where' => 'sometimes|array',
            'where.*' => 'array|size:3'
        ]));

        if ($validator->fails()) return [
            'error' => 1,
            'msg' => $validator->errors()
        ];

        if (method_exists($this, '__originListsBeforeHooks') &&
            !$this->__originListsBeforeHooks()) {
            return $this->origin_lists_before_result;
        }

        try {
            $condition = $this->origin_lists_condition;
            if (isset($this->post['where'])) $condition = array_merge(
                $condition,
                $this->post['where']
            );

            $lists = DB::table($this->model)
                ->where($condition)
                ->orderBy($this->origin_lists_order_columns, $this->origin_lists_order_direct)
                ->get($this->origin_lists_columns);

            return method_exists($this, '__originListsCustomReturn') ? $this->__originListsCustomReturn($lists) : [
                'error' => 0,
                'data' => $lists
            ];
        } catch (QueryException $e) {
            return [
                'error' => 1,
                'msg' => $e->errorInfo
            ];
        }
    }
}