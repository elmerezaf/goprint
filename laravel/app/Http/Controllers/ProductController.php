<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 产品列表页
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $category = $request->category;
            // Support both numeric cat_id and string slug-based lookup
            if (is_numeric($category)) {
                $query->where('cat_id', $category);
            } else {
                // Try to match by category name slug
                $cat = Category::where('cat_name', 'like', "%$category%")->first();
                if ($cat) {
                    $query->where('cat_id', $cat->cat_id);
                }
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('pro_name', 'like', "%$search%")
                  ->orWhere('pro_desc', 'like', "%$search%");
        }

        $products = $query->paginate(12);
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    // 产品详情页
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
}
