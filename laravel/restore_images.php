<?php
// 恢复产品图片数据库记录
$host = '127.0.0.1';
$dbname = 'goprint_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully!\n";

    // 更新产品图片记录
    $images = [
        1 => '1778222064.jpg',
        2 => '1778222125.jpg',
        3 => '1778222139.jpg',
        4 => '1778222152.jpg',
        5 => '1778222165.jpg'
    ];

    foreach ($images as $productId => $filename) {
        $stmt = $pdo->prepare("UPDATE product SET pro_image = ? WHERE pro_id = ?");
        $stmt->execute([$filename, $productId]);
        echo "Updated product $productId with image: $filename\n";
    }

    echo "\nAll product images restored!\n";

    // 验证更新
    echo "\nVerifying product data:\n";
    $result = $pdo->query("SELECT pro_id, pro_name, pro_image FROM product");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "- Product {$row['pro_id']}: {$row['pro_name']} - Image: {$row['pro_image']}\n";
    }

} catch(PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}
