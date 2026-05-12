<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\DB;

echo "=== 开始修复所有产品图片 ===\n\n";

// 产品ID到图片的完整映射
$productImageMap = [
    1 => 'business-card_1.png',
    2 => 'flyer_1.png',
    3 => 'brochure_1.png',
    4 => 'flyer_2.png',
    5 => 'business-card_2.png',
    6 => 'brochure_2.png',
    7 => 'brochure_3.png',
    8 => 'poster_1.png',
    9 => 'gop1 (3).png',
    10 => 'gop1 (4).png',
    11 => 'gop1 (5).png',
    12 => 'gop1 (8).png',
    13 => 'gop1 (9).png',
    14 => 'gop1 (10).png',
    15 => 'gop1 (14).png',
    16 => 'gop1 (15).png',
    17 => 'gop1 (20).png',
    18 => 'poster_2.png',
    19 => 'poster_3.png',
    20 => 'poster_4.png',
    21 => 'banner_1.png',
    22 => 'service-affordable.jpg',
    23 => 'service-design.jpg',
    24 => 'hero-banner-business-cards.jpg',
    25 => 'hero-banner-fast-delivery.jpg',
    26 => 'hero-banner-flyers.jpg',
    27 => 'hero-banner-quality.jpg',
    28 => 'service-eco.jpg',
    29 => 'service-fast-delivery.jpg',
    30 => 'service-quality.jpg',
    31 => 'service-support.jpg',
    32 => 'banner_1.png',
    33 => 'poster_1.png',
    34 => 'poster_2.png',
    35 => 'poster_3.png'
];

$updatedCount = 0;
foreach ($productImageMap as $productId => $imageName) {
    $product = Product::find($productId);
    if ($product) {
        $product->pro_image = $imageName;
        $product->save();
        echo "✅ 产品 {$productId} ({$product->pro_name}) 更新为: {$imageName}\n";
        $updatedCount++;
    } else {
        echo "❌ 产品 {$productId} 不存在\n";
    }
}

echo "\n=== 共更新了 {$updatedCount} 个产品的图片\n";
echo "=== 产品图片修复完成！ ===\n";
