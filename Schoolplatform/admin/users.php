<?php

require '../includes/session_timeout.php';
requireRole('admin');

require '../config/db.php';

$sql = "SELECT users.*, roles.role_name
        FROM users
        JOIN roles ON users.role_id = roles.role_id";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Users</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h2>All Users</h2>

<table class="table table-bordered">

    <thead>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>

    </thead>

    <tbody>

    <?php while($row = $result->fetch_assoc()): ?>

        <tr>

            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['role_name']; ?></td>

        </tr>

    <?php endwhile; ?>

    </tbody>

</table>

</body>
</html>