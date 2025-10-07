<?php
session_start();
include 'db_connect.php';

if (!isset($_GET['id'])) {
    die("Missing staff ID.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM Staff WHERE StaffID = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
?>