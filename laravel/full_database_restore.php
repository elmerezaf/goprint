<?php
// Full database restore script
$host = '127.0.0.1';
$dbname = 'goprint_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "========================================\n";
    echo "    MySQL Full Database Restore Script\n";
    echo "========================================\n\n";

    // Disable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    // 1. Restore users table
    echo "[1/5] Restoring user accounts...\n";

    $pdo->exec("DROP TABLE IF EXISTS users");
    $pdo->exec("CREATE TABLE users (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        email_verified_at TIMESTAMP NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(20) DEFAULT 'user',
        remember_token VARCHAR(100) NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // Insert accounts
    $adminPassword = '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
    $now = date('Y-m-d H:i:s');

    $stmt->execute(['Administrator', 'elmerezaf@gmail.com', $adminPassword, 'admin', $now, $now]);
    echo "  [OK] Admin: elmerezaf@gmail.com / password123\n";

    $stmt->execute(['Test User', 'test@example.com', $adminPassword, 'user', $now, $now]);
    echo "  [OK] Test User: test@example.com / password123\n";

    // 2. Restore addresses table
    echo "\n[2/5] Restoring address data...\n";

    $pdo->exec("DROP TABLE IF EXISTS addresses");
    $pdo->exec("CREATE TABLE addresses (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT UNSIGNED NOT NULL,
        recipient_name VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        address VARCHAR(500) NOT NULL,
        is_default TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $stmt = $pdo->prepare("INSERT INTO addresses (user_id, recipient_name, phone, address, is_default, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([1, 'Chan Tai Ming', '91234567', '1 Garden Road Central Hong Kong', 1, $now, $now]);
    $stmt->execute([1, 'Li Siu Ming', '98765432', '100 Nathan Road Mong Kok Kowloon', 0, $now, $now]);
    echo "  [OK] Address data restored\n";

    // 3. Restore orders table
    echo "\n[3/5] Restoring order data...\n";

    $pdo->exec("DROP TABLE IF EXISTS orders");
    $pdo->exec("CREATE TABLE orders (
        order_id VARCHAR(32) PRIMARY KEY,
        user_id BIGINT UNSIGNED,
        order_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        order_status TINYINT(4) DEFAULT 0,
        shipping_method ENUM('In-store Pickup','Local Delivery') DEFAULT 'In-store Pickup',
        shipping_address VARCHAR(500),
        shipping_phone VARCHAR(20),
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $stmt = $pdo->prepare("INSERT INTO orders (order_id, user_id, order_amount, order_status, shipping_method, shipping_address, shipping_phone, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(['ORD20260508001', 1, 248.00, 1, 'Local Delivery', '1 Garden Road Central Hong Kong', '91234567', date('2026-05-08 10:30:00'), $now]);
    $stmt->execute(['ORD20260508002', 1, 598.00, 2, 'In-store Pickup', 'In-store Pickup', '91234567', date('2026-05-08 14:20:00'), $now]);
    $stmt->execute(['ORD20260509001', 1, 150.00, 0, 'Local Delivery', '100 Nathan Road Mong Kok Kowloon', '98765432', $now, $now]);
    echo "  [OK] Order data restored (3 orders)\n";

    // 4. Verify product data
    echo "\n[4/5] Verifying product data...\n";

    $stmt = $pdo->query("SELECT pro_id, pro_name, pro_image FROM product ORDER BY pro_id");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        echo "  - Product {$product['pro_id']}: {$product['pro_name']}";
        if ($product['pro_image']) {
            echo " [Has image: {$product['pro_image']}]";
        } else {
            echo " [No image]";
        }
        echo "\n";
    }
    echo "  [OK] Product data verified\n";

    // 5. Restore image associations
    echo "\n[5/5] Restoring image associations...\n";

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
        echo "  [OK] Product $productId: $filename\n";
    }

    // Re-enable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    echo "\n========================================\n";
    echo "    [OK] Database restore completed!\n";
    echo "========================================\n\n";

    echo "Restored Accounts:\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Admin: elmerezaf@gmail.com\n";
    echo "Password: password123\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    echo "Restored Orders:\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    $stmt = $pdo->query("SELECT order_id, order_amount, order_status, created_at FROM orders ORDER BY created_at DESC");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $status = $row['order_status'] == 0 ? 'Pending' : ($row['order_status'] == 1 ? 'Paid' : 'Completed');
        echo "  Order: {$row['order_id']} | Amount: HK\$ {$row['order_amount']} | Status: {$status}\n";
    }
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    echo "All data successfully restored!\n";
    echo "Please refresh the page to test.\n";

} catch(PDOException $e) {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    die("Error: " . $e->getMessage() . "\n");
}