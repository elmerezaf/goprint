<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cart as $id => $details) {
            $product = is_numeric($id) ? Product::find($id) : null;

            $productObj = $product ?: (object)[
                'pro_id' => $id,
                'pro_name' => $details['name'] ?? '定制印刷品',
                'pro_price' => $details['price'] ?? 88,
                'pro_stock' => 9999,
                'pro_desc' => '在线设计定制印刷品',
                'pro_image' => null,
                'category' => null
            ];

            $products[] = [
                'product' => $productObj,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
                'total' => $details['quantity'] * $details['price'],
                'design_token' => $details['design_token'] ?? null
            ];
            $total += $details['quantity'] * $details['price'];
        }

        return view('cart.index', compact('products', 'total'));
    }

    public function add(Request $request)
    {
        $productId = $request->product_id;
        $designToken = $request->design_token;
        $productName = $request->product_name;
        $productPrice = $request->product_price;
        $quantity = (int)($request->quantity ?? 1);

        if ($productId) {
            $product = Product::find($productId);
            if ($product) {
                $productName = $product->pro_name;
                $productPrice = $product->pro_price;
            }
        }

        if (!$productName && !$designToken) {
            return back()->with('error', '產品不存在');
        }

        if (!$productId || $productId == '0') {
            $productId = $designToken ? 'design_' . abs(crc32($designToken)) : uniqid('temp_');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $productName ?: '定制印刷品',
                'quantity' => $quantity,
                'price' => floatval($productPrice) ?: 88,
                'image' => null,
                'design_token' => $designToken
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', '產品已添加到購物車');
    }

    public function update(Request $request)
    {
        $productId = $request->product_id;

        if ($request->quantity <= 0) {
            return $this->remove($request);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = (int)$request->quantity;
            session()->put('cart', $cart);

            $itemTotal = $cart[$productId]['quantity'] * $cart[$productId]['price'];

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '購物車已更新',
                    'cartCount' => array_sum(array_column($cart, 'quantity')),
                    'itemTotal' => $itemTotal,
                    'cartTotal' => array_reduce($cart, function($sum, $item) {
                        return $sum + ($item['quantity'] * $item['price']);
                    }, 0)
                ]);
            }

            return back()->with('success', '購物車已更新');
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['error' => '產品不存在於購物車'], 404);
        }

        return back()->with('error', '產品不存在於購物車');
    }

    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '產品已從購物車移除',
                    'cartCount' => array_sum(array_column($cart, 'quantity')),
                    'cartTotal' => array_reduce($cart, function($sum, $item) {
                        return $sum + ($item['quantity'] * $item['price']);
                    }, 0)
                ]);
            }

            return back()->with('success', '產品已從購物車移除');
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['error' => '產品不存在於購物車'], 404);
        }

        return back()->with('error', '產品不存在於購物車');
    }

    public function clear(Request $request)
    {
        session()->forget('cart');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '購物車已清空',
                'cartCount' => 0,
                'cartTotal' => 0
            ]);
        }

        return back()->with('success', '購物車已清空');
    }
}