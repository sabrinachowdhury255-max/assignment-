<?php
include 'db_connect.php';

$programme_id = $_POST['programme_id'];
$name = $_POST['student_name'];
$email = $_POST['email'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Interest Confirmation</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<?php
try {
    $stmt = $pdo->prepare("INSERT INTO InterestedStudents (ProgrammeID, StudentName, Email) VALUES (?, ?, ?)");
    $stmt->execute([$programme_id, $name, $email]);
    echo "<p>✅ Thank you for registering your interest, <strong>" . htmlspecialchars($name) . "</strong>!</p>";
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo "<p style='color:red;'>⚠️ You've already registered interest for this programme.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>
<p><a href="index.php">← Back to Programmes</a></p>
</body>
</html>