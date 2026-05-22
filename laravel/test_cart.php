<?php
// Test file to verify cart functionality

// Start session
session_start();

// Set test cart data
$_SESSION['cart'] = [
    '1' => [
        'name' => '測試產品 - 名片印刷',
        'quantity' => 2,
        'price' => 98.00
    ],
    '2' => [
        'name' => '測試產品 - 傳單印刷',
        'quantity' => 1,
        'price' => 150.00
    ]
];

echo "✅ Cart session data set successfully!\n";
echo "\nCart contents:\n";
print_r($_SESSION['cart']);
echo "\n";
echo "Total: HK$" . array_sum(array_map(function($item) {
    return $item['quantity'] * $item['price'];
}, $_SESSION['cart'])) . "\n";
echo "\nVisit http://127.0.0.1:8000/cart to see the result.\n";
