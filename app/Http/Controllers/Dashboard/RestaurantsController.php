<?php

namespace App\Http\Controllers\Dashboard;

use App\Restaurant;
use App\Settings;
use App\User;
use Validator;
use Auth;
use DB;

class RestaurantsController extends BaseController
{
    protected $base = 'dashboard.restaurants';
    protected $cls = 'App\Restaurant';
    protected $orderBy = 'sort';
    protected $orderByDir = 'ASC';
    protected $images = ['image'];

    public function getRules()
    {
        $rules = [
            'name' => 'required',
            'sort' => 'required',
            'username' => 'required',
            'owner_username' => 'required',
        ];

        if (Settings::getSettings()->multiple_cities) {
            $rules['city_id'] = 'required';
        }

        return $rules;
    }

    protected function getIndexItems($data)
    {
        if ($data != null) {
            $restaurants = Restaurant::policyScope();
            if (is_array($data) && isset($data['q'])) {
                $restaurants = $restaurants->where('name', 'LIKE', '%' . $data['q'] . '%');
            }
            // FIXME: creating wroks without this i dont know how the hell :(())
            // save username to table  FIXME: 
            if (is_array($data) && isset($data['q'])) {
                $restaurants = $restaurants->where('username', 'LIKE', '%' . $data['q'] . '%');
            }
            // save owner_username to table  FIXME: 
            if (is_array($data) && isset($data['q'])) {
                $restaurants = $restaurants->where('owner_username', 'LIKE', '%' . $data['q'] . '%');
            }
            if (is_array($data) && isset($data['city_id'])) {
                $restaurants = $restaurants->where('city_id', $data['city_id']);
            }

            return $restaurants->paginate(20);
        } else {
            // just testing
            // if (is_array($data) && isset($data['username'])) {
            //     $restaurants = $restaurants->where('username', $data['username']);
            // }
            // FIXME: too close to solve indexing = username
            return Restaurant::policyScope()->paginate(20);
            // FIXME:
            // $restaurants = User::find($owner_id)->restaurants;
            // $restaurants = Auth::table('restorants')->where('username', auth()->username())->get();
            // $restaurants = User::find('username')->restaurants;
            // $restaurants = DB::table('restaurants')->where('username', User::username())->get();

        }
    }
}
