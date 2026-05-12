<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;

echo "=== 检查畫冊印刷产品图片 ===\n\n";

$product = Product::where('pro_name', '畫冊印刷')->first();
if ($product) {
    echo "产品ID: {$product->pro_id}\n";
    echo "产品名称: {$product->pro_name}\n";
    echo "当前图片: {$product->pro_image}\n";
    
    $imagePath = public_path('storage/products/' . $product->pro_image);
    echo "图片路径: {$imagePath}\n";
    echo "文件存在: " . (file_exists($imagePath) ? '✅ 存在' : '❌ 不存在') . "\n\n";
    
    // 列出所有可用的brochure图片
    echo "=== 可用的brochure图片 ===\n";
    $files = glob(public_path('storage/products/brochure*.png'));
    foreach ($files as $file) {
        echo "📄 " . basename($file) . "\n";
    }
} else {
    echo "❌ 未找到畫冊印刷产品\n";
}
