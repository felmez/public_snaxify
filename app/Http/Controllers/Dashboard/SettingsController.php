<?php

namespace App\Http\Controllers\Dashboard;

use App\Settings;
use Gate;
use Illuminate\Http\Request;

class SettingsController extends BaseController
{
    protected $base = 'dashboard.settings';
    protected $cls = 'App\Settings';
    protected $checkboxes = ['tax_included', 'multiple_restaurants', 'multiple_cities', 'signup_required'];

    public function index(Request $request)
    {
        if ( ! Gate::allows('create', $this->cls)) {
            return redirect('/');
        }
        $item = Settings::getSettings();

        return view($this->base . '.form', array_merge(compact('item'), $this->getAdditionalData()));
    }
}
