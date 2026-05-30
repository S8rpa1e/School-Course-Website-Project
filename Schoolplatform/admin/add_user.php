<?php

require '../includes/session_timeout.php';
requireRole('admin');

require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = $_POST['role_id'];

    $sql = "INSERT INTO users
            (full_name, email, password_hash, role_id)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssi",
        $full_name,
        $email,
        $password,
        $role_id
    );

    if ($stmt->execute()) {

        $user_id = $conn->insert_id;

        if ($role_id == 1) {

            $conn->query("
                INSERT INTO students (user_id)
                VALUES ($user_id)
            ");
        }

        elseif ($role_id == 2) {

            $conn->query("
                INSERT INTO teachers (user_id)
                VALUES ($user_id)
            ");
        }

        echo "User added successfully.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h2>Add User</h2>

<form method="POST">

    <div class="mb-3">
        <input type="text"
               name="full_name"
               class="form-control"
               placeholder="Full Name"
               required>
    </div>

    <div class="mb-3">
        <input type="email"
               name="email"
               class="form-control"
               placeholder="Email"
               required>
    </div>

    <div class="mb-3">
        <input type="password"
               name="password"
               class="form-control"
               placeholder="Password"
               required>
    </div>

    <div class="mb-3">

        <select name="role_id" class="form-select">

            <option value="1">Student</option>
            <option value="2">Teacher</option>
            <option value="3">Admin</option>

        </select>

    </div>

    <button type="submit" class="btn btn-primary">
        Add User
    </button>

</form>

</body>
</html>