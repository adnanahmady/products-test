<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Custom\Helpers\ProductFilter;

class ProductController extends Controller
{
    public function index(ProductFilter $filter)
    {
        $products = Product::with('colors')
            ->filter($filter)
            ->paginate();

        return view('products.index', compact('products'));
    }
}
