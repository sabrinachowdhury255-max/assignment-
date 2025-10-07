<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include 'db_connect.php';

$modules = $pdo->query("
    SELECT m.ModuleID, m.ModuleName, s.Name AS Leader
    FROM Modules m
    LEFT JOIN Staff s ON m.ModuleLeaderID = s.StaffID
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head><title>Manage Modules</title>
<link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h1>Manage Modules</h1>
    <table border="1" cellpadding="8">
        <tr><th>Module Name</th><th>Leader</th><th>Actions</th></tr>
        <?php foreach ($modules as $m): ?>
            <tr>
                <td><?= htmlspecialchars($m['ModuleName']) ?></td>
                <td><?= htmlspecialchars($m['Leader']) ?></td>
                <td><a href="edit_module.php?id=<?= $m['ModuleID'] ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="admin_dashboard.php">← Back to Dashboard</a></p>
</body>
</html>