<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use APp\Models\Product;
use Illuminate\Support\Facades\DB;


class ProductController extends BaseController
{
    public function getProduct($id)
    {
        $product = DB::table('products')->find($id);
    
        if ($product) {
            return response()->json(['data' => $product]);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
    
    public function getProducts()
    {
        $menuLists = DB::table('products')->get();
        return response()->json(['data' => $menuLists]);
    }
}
