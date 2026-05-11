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
            $product = Product::find($id);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                    'total' => $details['quantity'] * $details['price']
                ];
                $total += $details['quantity'] * $details['price'];
            }
        }

        return view('cart.index', compact('products', 'total'));
    }

    public function add(Request $request)
    {
        $product = Product::find($request->product_id);
        if (!$product) {
            return back()->with('error', '產品不存在');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->pro_id])) {
            $cart[$product->pro_id]['quantity']++;
        } else {
            $cart[$product->pro_id] = [
                'name' => $product->pro_name,
                'quantity' => 1,
                'price' => $product->pro_price,
                'image' => null
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', '產品已添加到購物車');
    }

    public function update(Request $request)
    {
        if ($request->quantity <= 0) {
            return $this->remove($request);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', '購物車已更新');
        }

        return back()->with('error', '產品不存在於購物車');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
            return back()->with('success', '產品已從購物車移除');
        }

        return back()->with('error', '產品不存在於購物車');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', '購物車已清空');
    }
}
