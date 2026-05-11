<?php
echo "=====================================\n";
echo "   Database Diagnostic Tool\n";
echo "=====================================\n\n";

$host = 'localhost';
$dbname = 'goprint_db';
$username = 'root';
$password = '';

try {
    echo "[1] Testing database connection...\n";
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "    ✓ Database connection successful\n\n";

    echo "[2] Checking users table...\n";
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "    Total users: $userCount\n\n";

    echo "[3] User details:\n";
    $stmt = $pdo->query("SELECT id, name, email, role FROM users");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "    - ID: {$row['id']}, Name: {$row['name']}, Email: {$row['email']}, Role: {$row['role']}\n";
    }
    echo "\n";

    echo "[4] Resetting passwords...\n";
    $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = ?");
    $stmt->execute([$hashedPassword]);
    echo "    ✓ Password reset for all users\n";
    echo "    New password: password\n\n";

    echo "[5] Checking products table...\n";
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM products");
    $productCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "    Total products: $productCount\n\n";

    echo "[6] Checking orders table...\n";
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM orders");
    $orderCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "    Total orders: $orderCount\n\n";

    echo "=====================================\n";
    echo "   Diagnostic Complete\n";
    echo "=====================================\n";
    echo "\nLogin credentials:\n";
    echo "  Admin: elmerezaf@gmail.com / password\n";
    echo "  User: test@example.com / password\n";

} catch (PDOException $e) {
    echo "[ERROR] " . $e->getMessage() . "\n";
    echo "\nPossible issues:\n";
    echo "  1. MySQL service not running\n";
    echo "  2. Database does not exist\n";
    echo "  3. Database connection configuration error\n";
}
?>