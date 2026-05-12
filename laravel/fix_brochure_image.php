<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;

echo "=== 修复畫冊印刷产品图片 ===\n\n";

$product = Product::where('pro_name', '畫冊印刷')->first();
if ($product) {
    $product->pro_image = 'brochure_1.png';
    $product->save();
    
    echo "✅ 畫冊印刷产品图片已更新为: brochure_1.png\n";
    
    // 验证修复
    $imagePath = public_path('storage/products/brochure_1.png');
    echo "验证文件存在: " . (file_exists($imagePath) ? '✅ 存在' : '❌ 不存在') . "\n";
} else {
    echo "❌ 未找到畫冊印刷产品\n";
}
