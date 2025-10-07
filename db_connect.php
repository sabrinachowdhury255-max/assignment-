<?php
$host = 'localhost';
$dbname = 'student_course_hub';
$username = 'root'; // default for XAMPP
$password = '';     // leave blank for XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>