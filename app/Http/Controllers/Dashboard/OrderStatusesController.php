<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Validator;

class OrderStatusesController extends BaseController
{
    protected $base = 'dashboard.order_statuses';
    protected $cls = 'App\OrderStatus';
    protected $orderBy = 'sort';
    protected $orderByDir = 'ASC';

    public function getRules()
    {
        return [
            'name' => 'required',
            'sort' => 'required'
        ];
    }
}
