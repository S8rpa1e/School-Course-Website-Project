<?php

session_start();
require 'config/db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();

    $result = $check->get_result();

    if ($result->num_rows > 0) {

        $message = "Email already exists.";

    } else {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $role_id = 1;

        $sql = "INSERT INTO users
                (full_name, email, password_hash, role_id)
                VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssi",
            $full_name,
            $email,
            $hashed,
            $role_id
        );

        if ($stmt->execute()) {

            $user_id = $conn->insert_id;

            $admin = $conn->prepare("INSERT INTO admins (user_id) VALUES (?)");
            $admin->bind_param("i", $user_id);
            $admin->execute();

            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-center">

    <div class="form-card">

        <h2>Sign In</h2>

        <?php if($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <input type="text"
                       name="full_name"
                       class="form-control"
                       placeholder="Full Name"
                       required>
            </div>

            <div class="form-group">
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Email"
                       required>
            </div>

            <div class="form-group">
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Password"
                       required>
            </div>

            <button type="submit" class="btn-primary-custom" style="width:100%;">
                Sign Up
            </button>

        </form>

    </div>

</div>

</body>
</html>