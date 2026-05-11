<?php
$email = 'elmerezaf@gmail.com';
$password = 'password';

$host = 'localhost';
$dbname = 'goprint_db';
$username = 'root';
$dbPassword = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "Found user!\n";
        echo "Stored password hash: " . $user['password'] . "\n";
        echo "Testing password verify...\n";
        
        if (password_verify($password, $user['password'])) {
            echo "✅ Password is CORRECT!\n";
        } else {
            echo "❌ Password is INCORRECT!\n";
            echo "Let me check the hash algorithm...\n";
            echo "Hash info: " . password_get_info($user['password'])['algoName'] . "\n";
        }
    } else {
        echo "User not found!\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>