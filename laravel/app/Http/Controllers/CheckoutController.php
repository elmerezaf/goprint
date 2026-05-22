<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class CheckoutController extends Controller
{
    private const FREE_SHIPPING_THRESHOLD = 500;
    private const PICKUP_SHIPPING_COST = 35;

    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', '購物車為空，請先添加商品');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $details) {
            $product = is_numeric($id) ? Product::find($id) : null;
            $itemTotal = $details['quantity'] * ($details['price'] ?? 0);
            $subtotal += $itemTotal;

            $cartItems[] = [
                'id' => $id,
                'name' => $details['name'] ?? ($product ? $product->pro_name : '定制印刷品'),
                'quantity' => $details['quantity'],
                'price' => $details['price'] ?? 0,
                'total' => $itemTotal,
                'design_token' => $details['design_token'] ?? null,
                'image' => $product ? $product->pro_image : null,
            ];
        }

        $shipping = $subtotal >= self::FREE_SHIPPING_THRESHOLD ? 0 : self::PICKUP_SHIPPING_COST;
        $total = $subtotal + ($shipping > 0 ? $shipping : 0);
        $freeShippingThreshold = self::FREE_SHIPPING_THRESHOLD;

        return view('checkout.index', compact(
            'cartItems', 'subtotal', 'shipping', 'total', 'freeShippingThreshold'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'payment_method' => 'required|in:stripe,bank_transfer',
            'shipping_method' => 'required|in:pickup,sf_cod',
            'notes' => 'nullable|string|max:1000',
        ], [
            'name.required' => '請輸入姓名',
            'email.required' => '請輸入電郵',
            'phone.required' => '請輸入電話',
            'address.required' => '請輸入送貨地址',
            'payment_method.required' => '請選擇付款方式',
            'shipping_method.required' => '請選擇送貨方式',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', '購物車為空');
        }

        $orderItems = [];
        $subtotal = 0;
        $designToken = null;

        foreach ($cart as $id => $details) {
            $itemTotal = $details['quantity'] * ($details['price'] ?? 0);
            $subtotal += $itemTotal;
            $orderItems[] = $details['name'] . ' × ' . $details['quantity'];
            if (!$designToken && !empty($details['design_token'])) {
                $designToken = $details['design_token'];
            }
        }

        $shippingCost = 0;
        if ($request->shipping_method === 'pickup') {
            $shippingCost = $subtotal >= self::FREE_SHIPPING_THRESHOLD ? 0 : self::PICKUP_SHIPPING_COST;
        }
        $totalPrice = $subtotal + $shippingCost;

        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'product' => implode(' | ', $orderItems),
            'size' => '定制',
            'material' => '在線設計',
            'printing_side' => '單面',
            'binding' => '無',
            'quantity' => 1,
            'price' => $totalPrice,
            'payment_method' => $request->payment_method,
            'shipping_method' => $request->shipping_method,
            'notes' => $request->notes,
            'design_token' => $designToken,
            'status' => 'pending',
        ]);

        try {
            Mail::to($order->email)->send(new OrderConfirmation($order));
        } catch (\Exception $e) {
            \Log::error('Checkout email failed: ' . $e->getMessage());
        }

        session()->forget('cart');

        switch ($request->payment_method) {
            case 'stripe':
                session(['pending_order_id' => $order->id]);
                return redirect()->route('checkout.stripe', ['order_id' => $order->id]);

            case 'bank_transfer':
                $order->status = 'awaiting_transfer';
                $order->save();
                return redirect()->route('checkout.thankyou', ['order_id' => $order->id]);

            default:
                return redirect()->route('checkout.thankyou', ['order_id' => $order->id]);
        }
    }

    public function stripePay($orderId)
    {
        $order = Order::findOrFail($orderId);

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'hkd',
                        'product_data' => ['name' => 'GoPrint - ' . $order->product],
                        'unit_amount' => (int)($order->price * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['order_id' => $order->id]),
                'cancel_url' => route('payment.cancel', ['order_id' => $order->id]),
                'metadata' => ['order_id' => $order->id],
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            \Log::error('Stripe error: ' . $e->getMessage());
            return redirect()->route('checkout.thankyou', ['order_id' => $order->id])
                ->with('error', '支付連結建立失敗，請聯絡客服。訂單已創建，可選擇銀行轉帳。');
        }
    }

    public function thankyou($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('checkout.thankyou', compact('order'));
    }
}
