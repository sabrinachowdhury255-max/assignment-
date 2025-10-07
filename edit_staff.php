<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include 'db_connect.php';

$staff_id = $_GET['id'] ?? 0;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['Name'];
    $job_title = $_POST['JobTitle'];
    $bio = $_POST['Bio'];
    $photo_filename = $staff['Photo'];

    if (!empty($_FILES['Photo']['name'])) {
        $target_dir = "uploads/";
        $photo_filename = basename($_FILES["Photo"]["name"]);
        $target_file = $target_dir . $photo_filename;
        move_uploaded_file($_FILES["Photo"]["tmp_name"], $target_file);
    }

    $stmt = $pdo->prepare("UPDATE Staff SET Name = ?, JobTitle = ?, Bio = ?, Photo = ? WHERE StaffID = ?");
    $stmt->execute([$name, $job_title, $bio, $photo_filename, $staff_id]);

    header("Location: manage_staff.php");
    exit;
}

// Fetch staff data
$stmt = $pdo->prepare("SELECT * FROM Staff WHERE StaffID = ?");
$stmt->execute([$staff_id]);
$staff = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head><title>Edit Staff</title>
<link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <h1>Edit Staff Profile</h1>
    <form method="post" enctype="multipart/form-data">
    <label>Name:</label><br>
    <input type="text" name="Name" value="<?= htmlspecialchars($staff['Name']) ?>" required><br><br>

    <label>Job Title:</label><br>
    <input type="text" name="JobTitle" value="<?= htmlspecialchars($staff['JobTitle'] ?? '') ?>"><br><br>

    <label>Bio:</label><br>
    <textarea name="Bio" rows="5" cols="50"><?= htmlspecialchars($staff['Bio'] ?? '') ?></textarea><br><br>

    <label>Photo:</label><br>
    <input type="file" name="Photo"><br><br>

    <button type="submit">Save Changes</button>
</form>
    <p><a href="manage_staff.php">← Back to Staff</a></p>
</body>
</html>