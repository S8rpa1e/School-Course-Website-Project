<?php

session_start();
$_SESSION['LAST_ACTIVITY'] = time();
require 'config/db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT users.*, roles.role_name
            FROM users
            JOIN roles ON users.role_id = roles.role_id
            WHERE users.email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password_hash'])) {

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['full_name'];
            $_SESSION['role'] = $user['role_name'];

            if ($user['role_name'] === 'admin') {
                header("Location: admin/dashboard.php");
            }

            elseif ($user['role_name'] === 'teacher') {
                header("Location: teacher/dashboard.php");
            }

            elseif ($user['role_name'] === 'student') {
                header("Location: student/dashboard.php");
            }

            exit();
        }
    }

    $message = "Invalid email or password.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-center">

    <div class="form-card">

        <h2>Login</h2>

        <?php if($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST">

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
                Login
            </button>

        </form>

    </div>

</div>

</body>
</html>