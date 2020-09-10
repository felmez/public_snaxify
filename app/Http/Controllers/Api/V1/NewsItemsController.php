<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\NewsItem;
use Illuminate\Http\Request;

class NewsItemsController extends Controller
{
    public function index(Request $request)
    {
        $city_id = $request->input('city_id');
        $items = NewsItem::all();
        if ($city_id != null) {
            $items = NewsItem::whereNull('city_id')->orWhere('city_id', $city_id)->get();
        }

        return response()->json($items);
    }
}
