<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;

echo "=== 检查和修复指定产品的图片 ===\n\n";

// 找到产品ID
$products = Product::whereIn('pro_name', ['商務名片套裝', '畫冊印刷'])->get();

foreach ($products as $product) {
    echo "产品ID: {$product->pro_id}, 名称: {$product->pro_name}, 当前图片: {$product->pro_image}\n";
}

echo "\n=== 更新图片 ===\n";

// 修复商務名片套裝 (ID: 6)
$product1 = Product::find(6);
if ($product1) {
    $product1->pro_image = 'business-card_2.png';
    $product1->save();
    echo "✅ 商務名片套裝已更新为: business-card_2.png\n";
}

// 修复畫冊印刷 (ID: 7)
$product2 = Product::find(7);
if ($product2) {
    $product2->pro_image = 'brochure_2.png';
    $product2->save();
    echo "✅ 畫冊印刷已更新为: brochure_2.png\n";
}

echo "\n=== 修复完成！===\n";
