<?php
session_start();
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;

header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    echo "<h2>Login Attempt</h2>";
    echo "<p>Email: " . htmlspecialchars($email) . "</p>";
    echo "<p>Password: " . htmlspecialchars($password) . "</p>";
    
    if (Auth::attempt(['email' => $email, 'password' => $password])) {
        echo "<p class='success'>✅ Login successful! Welcome, " . Auth::user()->name . "</p>";
        Auth::logout();
    } else {
        echo "<p class='error'>❌ Login failed</p>";
        
        $user = \App\Models\User::where('email', $email)->first();
        if ($user) {
            echo "<p>User exists in database</p>";
            echo "<p>Password verify: " . (password_verify($password, $user->password) ? 'OK' : 'FAIL') . "</p>";
        } else {
            echo "<p>User NOT found!</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Login</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 10px; box-sizing: border-box; }
        button { background: #0d6efd; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Simple Login Test</h1>
    
    <form method="POST">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="elmerezaf@gmail.com" required>
        </div>
        
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" value="password" required>
        </div>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>