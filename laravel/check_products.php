<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== 产品数据 ===\n";
$products = Product::all();
foreach ($products as $product) {
    echo "ID: {$product->pro_id}, 名称: {$product->pro_name}, 图片: {$product->pro_image}\n";
}

echo "\n=== 分类数据 ===\n";
$categories = Category::all();
foreach ($categories as $category) {
    echo "ID: {$category->cat_id}, 名称: {$category->cat_name}\n";
}
