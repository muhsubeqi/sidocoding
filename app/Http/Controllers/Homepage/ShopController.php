<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->paginate(12);
        $categories = ProductCategory::all();
        $newProduct = Product::orderBy('id', 'DESC')->limit(3)->get();
        return view('homepage/shop/index', compact('products','categories', 'newProduct'));
    }

    public function list($id)
    {
        $products = Product::where('product_categories_id', $id)->orderBy('id', 'DESC')->get();
        $categories = ProductCategory::all();
        $newProduct = Product::orderBy('id', 'DESC')->limit(3)->get();
        return view('homepage/shop/list', compact('products','categories', 'newProduct'));
    }
    
    public function detail($slug)
    {
        $product = Product::where('slug', 'LIKE', "%$slug%")->first();
        $categories = ProductCategory::all();
        $newProduct = Product::orderBy('id', 'DESC')->limit(3)->get();
        return view('homepage/shop/detail', compact('product', 'categories', 'newProduct'));
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'LIKE', "%$request->search%")->paginate(12);
        $categories = ProductCategory::all();
        $newProduct = Product::orderBy('id', 'DESC')->limit(3)->get();
        return view('homepage/shop/index', compact('products','categories', 'newProduct'));
    }
}