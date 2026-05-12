<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Starting product image update...\n\n";

$images = [
    '名片' => 'business-cards.jpg',
    '宣傳單張' => 'flyers.jpg',
    '海報' => 'posters.jpg',
    '小冊子' => 'booklets.jpg',
    '書刊' => 'booklets.jpg',
    '信封' => 'envelopes.jpg',
    '信紙' => 'envelopes.jpg',
    '貼紙' => 'stickers.jpg',
    '橫幅' => 'banners.jpg',
    'Banner' => 'banners.jpg',
];

$products = DB::table('products')->get();

foreach ($products as $product) {
    $imagePath = null;
    
    foreach ($images as $keyword => $filename) {
        if (stripos($product->pro_name, $keyword) !== false || 
            stripos($product->pro_description, $keyword) !== false) {
            $imagePath = 'products/' . $filename;
            break;
        }
    }
    
    if ($imagePath) {
        DB::table('products')
            ->where('pro_id', $product->pro_id)
            ->update(['pro_image' => $imagePath]);
        
        echo "✅ Updated: {$product->pro_name} -> {$imagePath}\n";
    } else {
        echo "⚠️  No match found for: {$product->pro_name}\n";
    }
}

echo "\n✅ Product images updated successfully!\n";
