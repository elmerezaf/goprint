<?php

$host = 'localhost';
$dbname = 'goprint_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $email = 'elmerezaf@gmail.com';
    
    $stmt = $pdo->prepare("SELECT role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        echo "当前角色: " . $result['role'] . PHP_EOL;
        
        $updateStmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE email = ?");
        $updateStmt->execute([$email]);
        
        echo "角色已成功更新为: admin" . PHP_EOL;
    } else {
        echo "未找到该用户" . PHP_EOL;
    }
    
} catch(PDOException $e) {
    echo "错误: " . $e->getMessage() . PHP_EOL;
}
?>