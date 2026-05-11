<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Route;

echo "Testing route generation...\n\n";

// Test 1: Check if route exists
$route = Route::getRoutes()->getByName('orders.show');
if ($route) {
    echo "✅ Route 'orders.show' exists\n";
    echo "   URI: " . $route->uri() . "\n";
} else {
    echo "❌ Route 'orders.show' NOT found\n";
}

// Test 2: Generate URL with parameter
try {
    $url = route('orders.show', ['id' => 1]);
    echo "\n✅ Generated URL for orders.show with id=1: " . $url . "\n";
} catch (\Exception $e) {
    echo "\n❌ Error generating URL: " . $e->getMessage() . "\n";
}

// Test 3: Test without parameter (should fail)
try {
    $url = route('orders.show');
    echo "\n⚠️ Generated URL without parameter: " . $url . "\n";
} catch (\Exception $e) {
    echo "\n✅ Correctly failed when no parameter provided: " . $e->getMessage() . "\n";
}

echo "\nDone!\n";
?>