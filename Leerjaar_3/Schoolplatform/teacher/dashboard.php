<?php

require '../includes/session_timeout.php';
requireRole('teacher');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="dashboard-header">

    <h2>Teacher Dashboard</h2>

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