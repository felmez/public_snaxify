<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Validator;

class UsersController extends BaseController
{
    protected $base = 'dashboard.users';
    protected $cls = 'App\User';
    protected $manyToMany = [
        'cities' => 'cities_ids'
    ];
    protected $checkboxes = [
        'access_full',
        'access_news',
        'access_categories',
        'access_products',
        'access_orders',
        'access_customers',
        'access_pushes',
        'access_delivery_areas',
        'access_promo_codes',
        'access_tax_groups',
        'access_cities',
        'access_restaurants',
        'access_settings',
        'access_users'
    ];

    protected function getIndexItems($data)
    {
        if ($data != null) {
            $users = User::orderBy($this->orderBy, $this->orderByDir);
            if (is_array($data) && isset($data['q'])) {
                $users = $users->where(function ($query) use ($data) {
                    $q = '%' . $data['q'] . '%';

                    return $query->where('email', 'LIKE', $q)->
                    orWhere('name', 'LIKE', $q);
                });
            }
            if (is_array($data) && isset($data['city_id'])) {
                $users = $users->whereHas('cities', function ($query) use ($data) {
                    return $query->where('id', $data['city_id']);
                })->orWhere('access_full', true);
            }

            return $users->paginate(20);
        } else {
            return call_user_func([$this->cls, 'orderBy'], $this->orderBy, $this->orderByDir)->paginate(20);
        }
    }

    protected function modifyRequestData($data)
    {
        if (isset($data['password'])) {
            if ( ! empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }
            unset($data['password_confirmation']);
        }
        if ($data['password'] == null) {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        return $data;
    }

    public function getRules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required'
        ];
        if (request()->has('password')) {
            $rules['password'] = 'required|confirmed';
        }

        return $rules;
    }
}
