<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Restaurant;
use Illuminate\Http\Request;
// use DB;

class RestaurantsController extends Controller
{
    public function index(Request $request)
    {
        $city_id = $request->input('city_id');
        if ($city_id != null) {
            $restaurants = Restaurant::where('city_id', $request->input('city_id'))->orderBy('sort', 'ASC')->get();
        } else {
            $restaurants = Restaurant::orderBy('sort', 'ASC')->get();
        }

        return response()->json($restaurants);
    }
}
