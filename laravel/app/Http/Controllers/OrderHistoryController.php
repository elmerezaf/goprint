<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::find($id);

        if (!$order || $order->user_id !== auth()->id()) {
            return redirect()->route('orders.index')->with('error', __('messages.order_not_found'));
        }

        return view('orders.show', compact('order'));
    }
}
