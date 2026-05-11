<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51TUMzXFNsWB4zz75Dtu0WuLatm2nrRZ0uXECtP9sTv8dpWnkhGGY8uuUEpxBg7FWVfpd4eH5annB42hF6dtHsq1100sFFS85Cs');

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'hkd',
                    'product_data' => ['name' => 'Test Product'],
                    'unit_amount' => 400, // HKD 4.00，Stripe 最低金額限制
                ],
                'quantity' => 1,
            ]
        ],
        'mode' => 'payment',
        'success_url' => 'http://localhost/success',
        'cancel_url' => 'http://localhost/cancel',
    ]);
    echo 'Success: ' . $session->url;
} catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>