<?php
include 'db_connect.php';

$programme_id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT ProgrammeName, Description FROM Programmes WHERE ProgrammeID = ?");
$stmt->execute([$programme_id]);
$programme = $stmt->fetch();

$modules_stmt = $pdo->prepare("
    SELECT m.ModuleName, pm.Year
    FROM ProgrammeModules pm
    JOIN Modules m ON pm.ModuleID = m.ModuleID
    WHERE pm.ProgrammeID = ?
    ORDER BY pm.Year
");
$modules_stmt->execute([$programme_id]);
$modules = $modules_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head><title><?= htmlspecialchars($programme['ProgrammeName']) ?></title>
<link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h1><?= htmlspecialchars($programme['ProgrammeName']) ?></h1>
    <p><?= htmlspecialchars($programme['Description']) ?></p>

    <h2>Modules</h2>
    <ul>
        <?php foreach ($modules as $module): ?>
            <li><?= htmlspecialchars($module['ModuleName']) ?> (Year <?= $module['Year'] ?>)</li>
        <?php endforeach; ?>
    </ul>

    <h2>Register Interest</h2>
    <form method="post" action="register_interest.php">
        <input type="hidden" name="programme_id" value="<?= $programme_id ?>">
        <input type="text" name="student_name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>