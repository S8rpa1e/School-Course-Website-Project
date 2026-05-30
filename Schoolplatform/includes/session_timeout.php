<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

function requireRole($role)
{
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header("Location: ../login.php");
        exit();
    }
}

$timeout_duration = 300;

if (isset($_SESSION['LAST_ACTIVITY'])) {

    $inactive_time = time() - $_SESSION['LAST_ACTIVITY'];

    if ($inactive_time > $timeout_duration) {

        session_unset();
        session_destroy();

        header("Location: ../login.php?timeout=1");
        exit();
    }
}

$_SESSION['LAST_ACTIVITY'] = time();
?>