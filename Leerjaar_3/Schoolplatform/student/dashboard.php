<?php

require '../includes/session_timeout.php';
requireRole('student');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="dashboard-header">

    <h2>Student Dashboard</h2>

    <a href="../logout.php" class="btn-secondary-custom">
        Logout
    </a>

</div>

<div class="dashboard-content">

    <div class="card">
        <h3>Welcome <?php echo $_SESSION['name']; ?></h3>
    </div>

</div>

</body>
</html>