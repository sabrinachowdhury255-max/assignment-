<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include 'db_connect.php';

$staff = $pdo->query("SELECT StaffID, Name, Photo FROM Staff")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Staff</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h1>Manage Staff Profiles</h1>
    <table border="1" cellpadding="8">
        <tr><th>Photo</th><th>Name</th><th>Actions</th></tr>
        <?php foreach ($staff as $s): ?>
            <tr>
                <td>
                    <?php if (!empty($s['Photo'])): ?>
                        <img src="uploads/<?= htmlspecialchars($s['Photo']) ?>" width="50" height="50" style="object-fit: cover;">
                    <?php else: ?>
                        <span>No photo</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($s['Name']) ?></td>
                <td><a href="edit_staff.php?id=<?= $s['StaffID'] ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="admin_dashboard.php">← Back to Dashboard</a></p>
</body>
</html>