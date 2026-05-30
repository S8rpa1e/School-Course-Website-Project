<?php
require 'db.php';

// Fouten laten zien (tijdelijk)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = "";

// Student verwijderen
if (isset($_GET['student'])) {
    $id = $_GET['student'];
    $check = $pdo->prepare("SELECT COUNT(*) FROM enrollments WHERE student_id = ?");
    $check->execute([$id]);

    if ($check->fetchColumn() > 0) {
        $message = "<p class='w3-red'>Student volgt al cursussen en kan niet verwijderd worden.</p>";
    } else {
        $pdo->prepare("DELETE FROM students WHERE id = ?")->execute([$id]);
        $message = "<p class='w3-green'>Student verwijderd</p>";
    }
}

// Cursus verwijderen
if (isset($_GET['course'])) {
    $id = $_GET['course'];
    $check = $pdo->prepare("SELECT COUNT(*) FROM enrollments WHERE course_id = ?");
    $check->execute([$id]);

    if ($check->fetchColumn() > 0) {
        $message = "<p class='w3-red'>Cursus is gekoppeld aan studenten en kan niet verwijderd worden.</p>";
    } else {
        $pdo->prepare("DELETE FROM courses WHERE id = ?")->execute([$id]);
        $message = "<p class='w3-green'>Cursus verwijderd</p>";
    }
}

// Inschrijving verwijderen
if (isset($_GET['enrollment'])) {
    $id = $_GET['enrollment'];
    $pdo->prepare("DELETE FROM enrollments WHERE id = ?")->execute([$id]);
    $message = "<p class='w3-green'>Inschrijving verwijderd</p>";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Verwijderen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <?= $message ?>
    <p>
        <a class="button-back" href="index.php">Terug naar overzicht</a>
    </p>
</div>
</body>
</html>
