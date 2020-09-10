<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Validator;

class DeliveryBoysController extends BaseController
{
    protected $base = 'dashboard.delivery_boys';
    protected $cls = 'App\DeliveryBoy';

    public function getRules()
    {
        return [
            'name' => 'required'
        ];
    }
}
