<?php
include 'db_connect.php';

$programme_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT StudentName, Email, RegisteredAt FROM InterestedStudents WHERE ProgrammeID = ?");
$stmt->execute([$programme_id]);
$students = $stmt->fetchAll();
?>
<link rel="stylesheet" href="admin_style.css">
<h1>Interested Students</h1>
<table>
    <tr><th>Name</th><th>Email</th><th>Registered At</th></tr>
    <?php foreach ($students as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['StudentName']) ?></td>
            <td><?= htmlspecialchars($s['Email']) ?></td>
            <td><?= $s['RegisteredAt'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>