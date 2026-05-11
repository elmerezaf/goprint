<?php
session_start();
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;

echo "Testing Laravel Authentication...\n";

$email = 'elmerezaf@gmail.com';
$password = 'password';

if (Auth::attempt(['email' => $email, 'password' => $password])) {
    echo "✅ Laravel Auth works! User logged in: " . Auth::user()->name . "\n";
    Auth::logout();
} else {
    echo "❌ Laravel Auth failed!\n";
    
    // Check if user exists
    $user = \App\Models\User::where('email', $email)->first();
    if ($user) {
        echo "User exists in DB\n";
        echo "Email: " . $user->email . "\n";
        echo "Password hash length: " . strlen($user->password) . "\n";
        echo "Password verify: " . (password_verify($password, $user->password) ? 'OK' : 'FAIL') . "\n";
    } else {
        echo "User NOT found in DB!\n";
    }
}
?>