<?php
require 'db.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['course_name'];
    $price = $_POST['price'];

    if ($price <= 0) {
        $msg = "<p class='w3-red'>Prijs moet groter dan 0 zijn</p>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO courses (course_name, price) VALUES (?, ?)");
        $stmt->execute([$name, $price]);
        $msg = "<p class='w3-green'>Cursus toegevoegd</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Cursus Toevoegen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Cursus Toevoegen</h2>

    <?= $msg ?>

    <form method="post" class="form">
        <label>Cursusnaam</label>
        <input name="course_name" placeholder="Cursusnaam" required>

        <label>Prijs</label>
        <input name="price" type="number" step="0.01" placeholder="Prijs" required>

        <button class="button button-edit" type="submit">Opslaan</button>
         <a class="button button-back" href="index.php">Terug</a>
    </form>
</div>
</body>
</html>
