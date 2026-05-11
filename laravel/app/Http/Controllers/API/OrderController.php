<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('email', $request->user()->email)->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }

    public function show(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order || $order->email !== $request->user()->email) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|string|max:255',
            'size' => 'required|string|max:50',
            'material' => 'required|string|max:50',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|email',
            'file' => 'nullable|string',
        ]);

        $order = Order::create([
            'product' => $request->product,
            'size' => $request->size,
            'material' => $request->material,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'file' => $request->file,
            'status' => 'pending',
        ]);

        return response()->json($order, 201);
    }
}
