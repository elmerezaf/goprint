<?php

echo "=== GoPrint Product Image Update Script ===\n\n";

try {
    $pdo = new PDO(
        'mysql:host=127.0.0.1;dbname=goprint_db;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "✅ Database connected successfully\n\n";
    
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
    
    $stmt = $pdo->query("SELECT pro_id, pro_name, pro_description FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Found " . count($products) . " products\n\n";
    
    foreach ($products as $product) {
        $imagePath = null;
        
        foreach ($images as $keyword => $filename) {
            if (stripos($product['pro_name'], $keyword) !== false || 
                stripos($product['pro_description'], $keyword) !== false) {
                $imagePath = 'products/' . $filename;
                break;
            }
        }
        
        if ($imagePath) {
            $updateStmt = $pdo->prepare("UPDATE products SET pro_image = ? WHERE pro_id = ?");
            $updateStmt->execute([$imagePath, $product['pro_id']]);
            
            echo "✅ Updated #{$product['pro_id']}: {$product['pro_name']} -> {$imagePath}\n";
        } else {
            echo "⚠️  No match: {$product['pro_name']}\n";
        }
    }
    
    echo "\n✅ All product images updated successfully!\n";
    
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
    echo "\nPlease make sure:\n";
    echo "1. MySQL service is running\n";
    echo "2. Database 'goprint_db' exists\n";
    echo "3. Products table has 'pro_id', 'pro_name', 'pro_description', and 'pro_image' columns\n";
}
