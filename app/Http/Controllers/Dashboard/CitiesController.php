<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Validator;

class CitiesController extends BaseController
{
    protected $base = 'dashboard.cities';
    protected $cls = 'App\City';
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
