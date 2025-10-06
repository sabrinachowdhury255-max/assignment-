<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include 'db_connect.php';

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Fetch programmes
try {
    $programmes = $pdo->query("SELECT ProgrammeID, ProgrammeName, IsVisible FROM Programmes")->fetchAll();
} catch (PDOException $e) {
    die("Error fetching programmes: " . $e->getMessage());
}

// Fetch staff list
try {
    $staff = $pdo->query("SELECT StaffID, Name FROM Staff")->fetchAll();
} catch (PDOException $e) {
    die("Error fetching staff: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="admin_style.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome to the Admin Dashboard</h1>
    <p><a href="logout.php">🔒 Logout</a></p> <!-- ✅ Added logout link -->

    <!-- 🎓 Programme Management Section -->
    <section>
        <h2>Programme Management</h2>
        <table border="1" cellpadding="8">
            <tr>
                <th>Programme Name</th>
                <th>Visible</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($programmes as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['ProgrammeName']) ?></td>
                    <td><?= $p['IsVisible'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <a href="toggle_visibility.php?id=<?= $p['ProgrammeID'] ?>">Toggle Visibility</a> |
                        <a href="view_interest.php?id=<?= $p['ProgrammeID'] ?>">View Interest</a> |
                        <a href="edit_programme.php?id=<?= $p['ProgrammeID'] ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <!-- 👥 Staff Management Section -->
    <section style="margin-top: 40px;">
        <h2>Staff Management</h2>
        <table border="1" cellpadding="8">
            <tr><th>Name</th><th>Actions</th></tr>
            <?php if (!empty($staff)): ?>
                <?php foreach ($staff as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['Name']) ?></td>
                        <td>
                            <a href="edit_staff.php?id=<?= htmlspecialchars($s['StaffID']) ?>">Edit</a> |
                            <a href="delete_staff.php?id=<?= htmlspecialchars($s['StaffID']) ?>" onclick="return confirm('Are you sure you want to delete this staff member?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2">No staff found.</td></tr>
            <?php endif; ?>
        </table>
        <p><a href="add_staff.php">➕ Add New Staff</a></p>
    </section>
</body>
</html>