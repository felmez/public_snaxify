<?php

namespace App\Http\Controllers\Api\V1;

use App\DeliveryArea;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryAreasController extends Controller
{
    public function index(Request $request)
    {
        $city_id = $request->input('city_id');
        if ($city_id != null) {
            $delivery_areas = DeliveryArea::where('city_id', $request->input('city_id'))->get();
        } else {
            // FIXME:
            $delivery_areas = DeliveryArea::orderBy('created_at', 'ASC')->get();
            // TODO: make map show selected restaurant's delivery area only
            // $delivery_areas = DeliveryArea::defaultOrder()->get();
            // $delivery_areas = DeliveryArea::where('id', '>', '0');
        }

        return response()->json($delivery_areas);
        // Categories Style

        // $restaurant_id = $request->input('restaurant_id');
        // if ($restaurant_id != null) {
        //     // TODO: for just selected restaurants show its categories
        //     $categories = Category::where('restaurant_id', $restaurant_id)->defaultOrder()->get();
        //     // TODO: show all categories even if restaurant selected
        //     // $categories = Category::defaultOrder()->get();
        // } else {
        //     $categories = Category::defaultOrder()->get();
        // }

    }
}
