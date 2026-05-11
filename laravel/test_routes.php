<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Models\User;

echo "========================================\n";
echo "         Route & Database Test\n";
echo "========================================\n\n";

// Test 1: Check database connection
echo "[1/4] Testing database connection...\n";
try {
    $orders = Order::count();
    echo "  ✅ Orders table exists with {$orders} records\n";
} catch (\Exception $e) {
    echo "  ❌ Error: " . $e->getMessage() . "\n";
}

// Test 2: Check users
echo "\n[2/4] Testing users...\n";
try {
    $users = User::all();
    foreach ($users as $user) {
        echo "  - User #{$user->id}: {$user->name} ({$user->email}) | role: {$user->role}\n";
    }
    echo "  ✅ Users table OK\n";
} catch (\Exception $e) {
    echo "  ❌ Error: " . $e->getMessage() . "\n";
}

// Test 3: Check routes
echo "\n[3/4] Checking routes...\n";
$routes = [
    'orders.index' => '/orders',
    'orders.show' => '/orders/{id}',
    'admin.dashboard' => '/admin',
    'admin.orders' => '/admin/orders',
];

foreach ($routes as $name => $uri) {
    try {
        $route = Route::getRoutes()->getByName($name);
        if ($route) {
            echo "  ✅ Route '{$name}' exists: {$uri}\n";
        } else {
            echo "  ❌ Route '{$name}' NOT FOUND\n";
        }
    } catch (\Exception $e) {
        echo "  ❌ Route '{$name}' Error: " . $e->getMessage() . "\n";
    }
}

// Test 4: Test order show route
echo "\n[4/4] Testing order show route generation...\n";
try {
    $order = Order::first();
    if ($order) {
        $url = route('orders.show', $order->id);
        echo "  ✅ Generated URL: {$url}\n";
    } else {
        echo "  ❌ No orders found\n";
    }
} catch (\Exception $e) {
    echo "  ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
echo "         Test Completed\n";
echo "========================================\n";
