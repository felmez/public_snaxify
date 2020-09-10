<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\City;
use App\DeliveryArea;
use App\Http\Controllers\Controller;
use App\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'settings' => Settings::getSettings(),
            'categories' => Category::defaultOrder()->get()
        ];
        if (Settings::getSettings()->multiple_cities) {
            $data['cities'] = City::orderBy('sort', 'ASC')->get();
        } else {
            $data['delivery_areas'] = DeliveryArea::all();
        }

        return response()->json($data);
    }
}
