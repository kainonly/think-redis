<?php

namespace lumen\bit\common;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

abstract class BitController extends BaseController
{
    protected $model;
    protected $post = [];

    protected $origin_lists_validate = [];
    protected $origin_lists_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $origin_lists_condition = [];
    protected $origin_lists_order_columns = 'create_time';
    protected $origin_lists_order_direct = 'desc';
    protected $origin_lists_columns = ['*'];

    protected $lists_validate = [];
    protected $lists_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $lists_condition = [];
    protected $lists_order_columns = 'create_time';
    protected $lists_order_direct = 'desc';
    protected $lists_columns = ['*'];

    protected $get_validate = [
        'id' => 'required|string|size:36'
    ];
    protected $get_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $get_condition = [];
    protected $get_select = ['*'];

    protected $add_validate = [];
    protected $add_default_validate = [
        'id' => 'sometimes|required|string|size:36'
    ];
    protected $add_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $add_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];
    protected $add_fail_result = [
        'error' => 1,
        'msg' => 'error:insert_fail'
    ];

    protected $edit_validate = [
        'id' => 'required|string|size:36',
        'switch' => 'required|bool'
    ];
    protected $edit_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $edit_fail_result = [
        'error' => 1,
        'msg' => 'error:fail'
    ];
    protected $edit_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];
    protected $edit_switch = false;

    protected $delete_validate = [
        'id' => 'required|string|size:36',
    ];
    protected $delete_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $delete_prep_result = [
        'error' => 1,
        'msg' => 'error:prep_fail'
    ];
    protected $delete_fail_result = [
        'error' => 1,
        'msg' => 'error:fail'
    ];
    protected $delete_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];

    public function __construct(Request $request)
    {
        $this->post = $request->toArray();
    }
}