<?php
// View layer: Display product information to end users
// Responsive layout for Hong Kong printing e-commerce platform
class ProductView {
    // Render product list UI
    public function renderProductList($product_data) {
        echo '<!DOCTYPE html>';
        echo '<html lang="zh-HK">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<title>GoPrint - 印刷產品列表</title>';
        echo '<style>';
        echo '.product-card { border:1px solid #ddd; padding:20px; margin:10px; border-radius:8px; width:300px; float:left; }';
        echo 'h1 { text-align: center; margin: 20px 0; }';
        echo '.clearfix::after { content: ""; clear: both; display: table; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        echo '<h1>GoPrint 專業印刷產品</h1>';
        echo '<div class="container clearfix">';

        if (empty($product_data)) {
            echo '<p style="text-align:center; width:100%;">暫無產品數據</p>';
        } else {
            foreach ($product_data as $product) {
                echo '<div class="product-card">';
                // 动态遍历所有字段，避免Undefined array key警告
                foreach ($product as $key => $value) {
                    echo '<p><strong>' . htmlspecialchars($key) . ':</strong> ' . htmlspecialchars($value) . '</p>';
                }
                echo '</div>';
            }
        }

        echo '</div>';
        echo '</body>';
        echo '</html>';
    }
}
?>