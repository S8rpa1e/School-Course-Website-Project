<?php

require '../includes/session_timeout.php';
requireRole('admin');

require '../config/db.php';

$userCount = $conn->query("SELECT COUNT(*) as total FROM users")
                  ->fetch_assoc()['total'];

$courseCount = $conn->query("SELECT COUNT(*) as total FROM courses")
                    ->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="dashboard-header">

    <h2>Admin Dashboard</h2>

    <a href="../logout.php" class="btn-secondary-custom">
        Logout
    </a>

</div>

<div class="dashboard-content">

    <div class="card">
        <h3>Welcome <?php echo $_SESSION['name']; ?></h3>
    </div>

    <div class="card">
        <h3>Total Users: <?php echo $userCount; ?></h3>
    </div>

    <div class="card">
        <h3>Total Courses: <?php echo $courseCount; ?></h3>
    </div>

    <a href="add_user.php" class="btn-primary-custom">
        Add User
    </a>

    <a href="users.php" class="btn-secondary-custom">
        View Users
    </a>

</div>

</body>
</html>