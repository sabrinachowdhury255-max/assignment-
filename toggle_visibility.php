<?php
include 'db_connect.php';

$programme_id = $_GET['id'];
$pdo->prepare("UPDATE Programmes SET IsVisible = NOT IsVisible WHERE ProgrammeID = ?")->execute([$programme_id]);

header("Location: admin_dashboard.php");
exit;