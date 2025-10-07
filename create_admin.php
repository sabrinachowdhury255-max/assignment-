<?php

include 'db_connect.php';

$email = 'admin@example.com';
$password = 'securepassword';
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO AdminLogins (Email, PasswordHash) VALUES (?, ?)");
$stmt->execute([$email, $hash]);

echo "Admin account created.";
?>