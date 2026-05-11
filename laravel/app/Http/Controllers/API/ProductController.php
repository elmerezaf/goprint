<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pro_name' => 'required|string|max:255',
            'pro_price' => 'required|numeric|min:0',
            'pro_category' => 'required|string|max:100',
            'pro_description' => 'nullable|string',
            'pro_size' => 'nullable|string|max:50',
            'pro_material' => 'nullable|string|max:50',
            'pro_specification' => 'nullable|string',
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'pro_name' => 'string|max:255',
            'pro_price' => 'numeric|min:0',
            'pro_category' => 'string|max:100',
            'pro_description' => 'nullable|string',
            'pro_size' => 'nullable|string|max:50',
            'pro_material' => 'nullable|string|max:50',
            'pro_specification' => 'nullable|string',
        ]);

        $product->update($request->all());

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
