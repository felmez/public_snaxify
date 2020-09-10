<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('category_id') == null) {
            $products = Product::all();
        } else {
            $products = Product::where('category_id', $request->input('category_id'))->get();
        }
        
        foreach ($products as $product) {
            $product->description = strip_tags($product->description);
        }

        return response()->json($products);
    }
}
