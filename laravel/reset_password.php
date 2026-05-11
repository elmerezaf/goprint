<?php
$host = 'localhost';
$dbname = 'goprint_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("UPDATE users SET password = ?");
    $stmt->execute([$hashedPassword]);
    
    echo "Password reset successfully for all users!\n";
    echo "New password for all accounts: password\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>