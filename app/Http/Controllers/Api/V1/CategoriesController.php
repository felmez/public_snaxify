<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $restaurant_id = $request->input('restaurant_id');
        if ($restaurant_id != null) {
            // TODO: for just selected restaurants show its categories
            $categories = Category::where('restaurant_id', $restaurant_id)->defaultOrder()->get();
            // TODO: show all categories even if restaurant selected
            // $categories = Category::defaultOrder()->get();
        } else {
            $categories = Category::defaultOrder()->get();
        }

        return response()->json($categories);
    }
}
