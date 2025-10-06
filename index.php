<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_connect.php';

$page = $_GET['page'] ?? 'welcome';
$mode = $_POST['mode'] ?? '';
$error = '';
$success = '';

// Handle login and admin logic only if on portal page
if ($page === 'portal') {
    if ($mode === 'student_login' && isset($_POST['student_name'])) {
        $_SESSION['student_name'] = $_POST['student_name'];
        $_SESSION['role'] = 'student';
    }

    if ($mode === 'admin_login' && isset($_POST['admin_name'], $_POST['admin_password'])) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE AdminName = ? AND Password = ?");
        $stmt->execute([$_POST['admin_name'], $_POST['admin_password']]);
        if ($stmt->rowCount() > 0) {
            $_SESSION['admin_name'] = $_POST['admin_name'];
            $_SESSION['role'] = 'admin';
        } else {
            $error = "Invalid admin credentials.";
        }
    }

    if (isset($_POST['register_interest'])) {
        $stmt = $pdo->prepare("INSERT INTO student_interest (student_name, email, programme_id, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$_POST['student_name'], $_POST['email'], $_POST['programme_id']]);
        $success = "Thank you, {$_POST['student_name']}! Your interest has been registered.";
    }

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'], $_POST['student_name'], $_POST['programme_id'])) {
            $student_name = $_POST['student_name'];
            $programme_id = $_POST['programme_id'];
            if ($_POST['action'] === 'delete') {
                $stmt = $pdo->prepare("DELETE FROM student_interest WHERE student_name = ? AND programme_id = ?");
                $stmt->execute([$student_name, $programme_id]);
                $success = "Entry deleted.";
            } elseif ($_POST['action'] === 'approve') {
                $success = "Entry approved.";
            }
        }

        if (isset($_POST['programme_action'], $_POST['programme_id'])) {
            $programme_id = $_POST['programme_id'];
            if ($_POST['programme_action'] === 'delete_programme') {
                $stmt = $pdo->prepare("DELETE FROM programmes WHERE ProgrammeID = ?");
                $stmt->execute([$programme_id]);
                $success = "Programme deleted.";
            } elseif ($_POST['programme_action'] === 'rename_programme' && isset($_POST['new_name'])) {
                $stmt = $pdo->prepare("UPDATE programmes SET ProgrammeName = ? WHERE ProgrammeID = ?");
                $stmt->execute([$_POST['new_name'], $programme_id]);
                $success = "Programme renamed.";
            }
        }
    }

    
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="admin_style.css">
    <title>NIELS BROCK</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; text-align: center; }
        button, input { padding: 10px 20px; margin: 10px; }
        .container { max-width: 1000px; margin: auto; }
        .success { color: green; }
        .error { color: red; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #3155c0ff; padding: 8px; text-align: left; }
        form.inline { display: inline; }

        .module-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
            text-align: left;
        }

        .module-box {
            background-color: #f4f4f4e6;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .module-box:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body>

<?php if ($page === 'welcome'): ?>
    <div class="container">
        <h1>Welcome to NIELS BROCK</h1>
        <p>Your gateway to future-ready education.</p>
        <a href="index.php?page=module"><button>MORE</button></a>
        
    </div>

<?php elseif ($page === 'module'): ?>
    <div class="container">
        <h2>Explore Our Modules</h2>
        <p>At NIELS BROCK, we offer a variety of programmes designed to prepare students for real-world challenges. Each module is crafted with industry relevance and academic excellence in mind.</p>

        <div class="module-grid">
            <div class="module-box">
                <h3>BSc Computer Science</h3>
                <p>this 3 years of program prepares you to Gain a strong foundation in algorithms, data structures, and software development. Prepare for careers in tech, research, and innovation.</p>
            </div>
            <div class="module-box">
                <h3>BSc Software Engineering</h3>
                <p>this is a 3 years of program and it helps you to Focus on designing, developing, and maintaining software systems. Master programming languages and agile methodologies.</p>
            </div>
            <div class="module-box">
                <h3>BSc Artificial Intelligence</h3>
                <p>this 3 years of program helps you to Explore machine learning, neural networks, and intelligent systems. Build smart applications and understand AI ethics.</p>
            </div>
            <div class="module-box">
                <h3>BSc Cyber Security</h3>
                <p>this 2 years of program helps you Learn to protect digital assets and defend against cyber threats. Study cryptography, network security, and ethical hacking.</p>
            </div>
            <div class="module-box">
                <h3>BSc Data Science</h3>
                <p>this 2 years of program helps you to learn Master data analysis, visualization, and predictive modeling. Turn data into actionable insights using modern tools.</p>
            </div>
            <div class="module-box">
                <h3>MSc Machine Learning</h3>
                <p>this is a 2 years of module program which will Advance your skills in deep learning, supervised and unsupervised learning. Ideal for careers in AI and robotics.</p>
            </div>
            <div class="module-box">
                <h3>MSc Cyber Security</h3>
                <p>this is a 2 years of course which will help you to Delve into advanced security protocols, threat intelligence, and digital forensics. Prepare for leadership roles in cybersecurity.</p>
            </div>
            <div class="module-box">
                <h3>MSc Data Science</h3>
                <p>after this 2 years of MSc program you will Focus on big data technologies, statistical modeling, and data-driven decision making. Work with real-world datasets.</p>
            </div>
            <div class="module-box">
                <h3>MSc Artificial Intelligence</h3>
                <p>this 2 years of program helps you to Explore cutting-edge AI research including NLP and computer vision. Lead innovation in AI-powered industries.</p>
            </div>
            <div class="module-box">
                <h3>MSc Software Engineering</h3>
                <p>this 2 years of program contains Specialize in scalable software systems, cloud computing, and DevOps. Prepare for advanced development roles.</p>
            </div>
        </div>

        <a href="index.php?page=portal"><button>APPLY NOW</button></a>
    </div>

<?php elseif ($page === 'portal'): ?>
    <?php if (!isset($_SESSION['role'])): ?>
        <h2>Student Login</h2>
        <form method="post">
            <input type="hidden" name="mode" value="student_login">
            <input type="text" name="student_name" placeholder="Your Name" required>
            <button type="submit">Enter</button>
        </form>

        <h2>Admin Login</h2>
        <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
        <form method="post">
            <input type="hidden" name="mode" value="admin_login">
            <input type="text" name="admin_name" placeholder="Admin Name" required>
            <input type="password" name="admin_password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

    <?php elseif ($_SESSION['role'] === 'student'): ?>
        <h2>Welcome, <?= htmlspecialchars($_SESSION['student_name']) ?>!</h2>
        <a href="logout.php">Logout</a>

        <?php
        $search = $_GET['search'] ?? '';
        $stmt = $pdo->prepare("SELECT ProgrammeID, ProgrammeName, Description FROM programmes WHERE ProgrammeName LIKE ?");
$stmt->execute(['%' . $search . '%']);
$programmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<form method="get">
    <input type="text" name="search" placeholder="Search programmes..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>

<?php if (!empty($success)): ?><p class="success"><?= $success ?></p><?php endif; ?>

<?php foreach ($programmes as $p): ?>
    <div style="margin-bottom:30px;">
        <h3><?= htmlspecialchars($p['ProgrammeName']) ?></h3>
        <p><?= nl2br(htmlspecialchars($p['Description'])) ?></p>
        <form method="post">
            <input type="hidden" name="programme_id" value="<?= $p['ProgrammeID'] ?>">
            <input type="hidden" name="student_name" value="<?= $_SESSION['student_name'] ?>">
            <input type="email" name="email" placeholder="Your Email" required>
            <button type="submit" name="register_interest">Register Interest</button>
        </form>
    </div>
<?php endforeach; ?>

<?php elseif ($_SESSION['role'] === 'admin'): ?>
    <h2>Admin Dashboard</h2>
    <a href="logout.php">Logout</a>
    <?php if (!empty($success)): ?><p class="success"><?= $success ?></p><?php endif; ?>

    <!-- 👩‍🎓 Student Interests -->
    <h3>Student Interests</h3>
    <?php
    $stmt = $pdo->query("SELECT si.student_name, si.email, si.programme_id, si.created_at, p.ProgrammeName FROM student_interest si LEFT JOIN programmes p ON si.programme_id = p.ProgrammeID ORDER BY si.created_at DESC");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <tr><th>Name</th><th>Email</th><th>Programme ID</th><th>Programme Name</th><th>Date</th><th>Actions</th></tr>
        <?php foreach ($students as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['student_name']) ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
            <td><?= htmlspecialchars($s['programme_id']) ?></td>
            <td><?= htmlspecialchars($s['ProgrammeName']) ?></td>
            <td><?= htmlspecialchars($s['created_at']) ?></td>
            <td>
                <form method="post" class="inline">
                    <input type="hidden" name="action" value="approve">
                    <input type="hidden" name="student_name" value="<?= $s['student_name'] ?>">
                    <input type="hidden" name="programme_id" value="<?= $s['programme_id'] ?>">
                    <button type="submit">Approve</button>
                </form>
                <form method="post" class="inline">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="student_name" value="<?= $s['student_name'] ?>">
                    <input type="hidden" name="programme_id" value="<?= $s['programme_id'] ?>">
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- 📚 Programme Management -->
    <h3>Programme Management</h3>
    <?php
    $stmt = $pdo->query("SELECT ProgrammeID, ProgrammeName FROM programmes ORDER BY ProgrammeName ASC");
    $programmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <tr><th>ID</th><th>Name</th><th>Actions</th></tr>
        <?php foreach ($programmes as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['ProgrammeID']) ?></td>
            <td><?= htmlspecialchars($p['ProgrammeName']) ?></td>
            <td>
                <form method="post" class="inline">
                    <input type="hidden" name="programme_action" value="delete_programme">
                    <input type="hidden" name="programme_id" value="<?= $p['ProgrammeID'] ?>">
                    <button type="submit" onclick="return confirm('Delete this programme?')">Delete</button>
                </form>
                <form method="post" class="inline">
                    <input type="hidden" name="programme_action" value="rename_programme">
                    <input type="hidden" name="programme_id" value="<?= $p['ProgrammeID'] ?>">
                    <input type="text" name="new_name" placeholder="New name" required>
                    <button type="submit">Rename</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- 👥 Staff Management -->
    <h3>Staff Management</h3>
    <?php
    $stmt = $pdo->query("SELECT StaffID, Name FROM staff ORDER BY Name ASC");
    $staff = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
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

<?php endif; ?> <!-- closes admin role check -->
<?php endif; ?> <!-- closes portal page check -->
</body>
</html>