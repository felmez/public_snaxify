<?php

namespace App\Http\Controllers\Dashboard;

use Validator;

class TaxGroupsController extends BaseController
{
    protected $base = 'dashboard.tax_groups';
    protected $cls = 'App\TaxGroup';

    public function getRules()
    {
        return [
            'name' => 'required',
            'value' => 'required'
        ];
    }
}
