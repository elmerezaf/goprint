<?php
// Fix orders table structure script
$host = '127.0.0.1';
$dbname = 'goprint_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "========================================\n";
    echo "    Orders Table Structure Fix Script\n";
    echo "========================================\n\n";

    // 1. Rebuild orders table to match Laravel model
    echo "[1/4] Rebuilding orders table...\n";

    $pdo->exec("DROP TABLE IF EXISTS orders");
    $pdo->exec("CREATE TABLE orders (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT UNSIGNED,
        name VARCHAR(255) NULL,
        phone VARCHAR(20) NULL,
        email VARCHAR(255) NULL,
        product VARCHAR(255) NULL,
        size VARCHAR(100) NULL,
        material VARCHAR(100) NULL,
        quantity INT DEFAULT 1,
        price DECIMAL(10,2) DEFAULT 0.00,
        file VARCHAR(255) NULL,
        status VARCHAR(50) DEFAULT 'pending',
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    echo "  [OK] Orders table rebuilt\n";

    // 2. Insert test order data
    echo "\n[2/4] Inserting test orders...\n";
    $now = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO orders (user_id, name, phone, email, product, size, material, quantity, price, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([1, 'Chan Tai Ming', '91234567', 'test@example.com', 'Business Cards', 'Standard', 'Premium', 100, 248.00, 'completed', date('2026-05-08 10:30:00'), $now]);
    $stmt->execute([1, 'Li Siu Ming', '98765432', 'test@example.com', 'Promotional Poster', 'A3', 'Glossy', 50, 598.00, 'processing', date('2026-05-08 14:20:00'), $now]);
    $stmt->execute([1, 'Chan Tai Ming', '91234567', 'test@example.com', 'Brochure Printing', 'A4', 'Premium', 30, 150.00, 'pending', $now, $now]);

    echo "  [OK] Inserted 3 test orders\n";

    // 3. Verify fix
    echo "\n[3/4] Verifying fix results...\n";

    $stmt = $pdo->query("SELECT id, product, status, price FROM orders");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "  - Order #{$row['id']}: {$row['product']} | {$row['status']} | HK\${$row['price']}\n";
    }
    echo "  [OK] Order data verified\n";

    // 4. Check users table
    echo "\n[4/4] Verifying users table...\n";

    $stmt = $pdo->query("SELECT id, name, email, role FROM users");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "  - User #{$row['id']}: {$row['name']} ({$row['email']}) | role: {$row['role']}\n";
    }
    echo "  [OK] User data verified\n";

    echo "\n========================================\n";
    echo "    [OK] Database fix completed!\n";
    echo "========================================\n\n";

    echo "Test Accounts:\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Admin: elmerezaf@gmail.com\n";
    echo "Password: password123\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    echo "All issues fixed! Please refresh the page to test.\n";

} catch(PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}