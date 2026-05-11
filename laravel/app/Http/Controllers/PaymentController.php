<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            $orderId = $request->order_id;
            \Log::info('Payment attempt for order: ' . $orderId);

            $order = Order::find($orderId);

            if (!$order) {
                \Log::error('Order not found: ' . $orderId);
                return response()->json(['error' => '訂單不存在'], 404);
            }

            \Log::info('Order found: ' . $order->id . ', Price: ' . $order->price);

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'hkd',
                            'product_data' => [
                                'name' => $order->product . ' - ' . $order->size . ' - ' . $order->material,
                            ],
                            'unit_amount' => (int)($order->price * 100),
                        ],
                        'quantity' => $order->quantity,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['order_id' => $order->id]),
                'cancel_url' => route('payment.cancel', ['order_id' => $order->id]),
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            \Log::info('Stripe session created: ' . $session->url);
            return response()->json(['url' => $session->url]);
            
        } catch (\Exception $e) {
            \Log::error('Payment error: ' . $e->getMessage());
            return response()->json(['error' => '支付連結建立失敗: ' . $e->getMessage()], 500);
        }
    }

    public function success(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::find($orderId);

        if ($order) {
            $order->status = 'paid';
            $order->save();
        }

        return view('payment.success', compact('order'));
    }

    public function cancel(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::find($orderId);

        return view('payment.cancel', compact('order'));
    }

    public function webhook(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $secret
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $orderId = $session->metadata->order_id;
                $order = Order::find($orderId);
                
                if ($order) {
                    $order->status = 'paid';
                    $order->stripe_session_id = $session->id;
                    $order->save();
                }
                break;
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                break;
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                break;
        }

        return response()->json(['status' => 'success']);
    }
}
