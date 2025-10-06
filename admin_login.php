<?php
include 'db_connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM AdminLogins WHERE Email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['PasswordHash'])) {
        session_start();
        $_SESSION['admin_id'] = $admin['AdminID'];
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!-- HTML Form -->
<form method="post">
    <input type="email" name="email" placeholder="Admin Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</form>