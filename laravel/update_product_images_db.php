<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;

$imageMappings = [
    1 => 'business-card_1.png',
    2 => 'flyer_1.png',
    3 => 'brochure_1.png',
    4 => 'flyer_2.png',
    5 => 'business-card_2.png'
];

echo "🔄 开始更新产品图片...\n";

foreach ($imageMappings as $proId => $imageName) {
    $product = Product::find($proId);
    if ($product) {
        $oldImage = $product->pro_image;
        $product->pro_image = $imageName;
        $product->save();
        echo "✅ 产品 $proId: $oldImage -> $imageName\n";
    } else {
        echo "❌ 产品 $proId 不存在\n";
    }
}

echo "\n🎉 数据库更新完成！\n";
echo "请清除浏览器缓存后刷新页面查看效果。\n";
?>