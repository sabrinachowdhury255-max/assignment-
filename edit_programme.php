<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include 'db_connect.php';

$programme_id = $_GET['id'] ?? 0;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['ProgrammeName'];
    $description = $_POST['Description'];
    $is_visible = isset($_POST['IsVisible']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE Programmes SET ProgrammeName = ?, Description = ?, IsVisible = ? WHERE ProgrammeID = ?");
    $stmt->execute([$name, $description, $is_visible, $programme_id]);

    header("Location: admin_dashboard.php");
    exit;
}

// Fetch current data
$stmt = $pdo->prepare("SELECT ProgrammeName, Description, IsVisible FROM Programmes WHERE ProgrammeID = ?");
$stmt->execute([$programme_id]);
$programme = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head><title>Edit Programme</title>
<link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h1>Edit Programme</h1>
    <form method="post">
        <label>Programme Name:</label><br>
        <input type="text" name="ProgrammeName" value="<?= htmlspecialchars($programme['ProgrammeName']) ?>" required><br><br>

        <label>Description:</label><br>
        <textarea name="Description" rows="5" cols="50"><?= htmlspecialchars($programme['Description']) ?></textarea><br><br>

        <label>
            <input type="checkbox" name="IsVisible" <?= $programme['IsVisible'] ? 'checked' : '' ?>>
            Visible to Students
        </label><br><br>

        <button type="submit">Save Changes</button>
    </form>
    <p><a href="admin_dashboard.php">← Back to Dashboard</a></p>
</body>
</html>