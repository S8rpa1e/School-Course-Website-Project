<?php
require 'db.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $birth = $_POST['birth_year'];
    $currentYear = date("Y");

    if ($birth > $currentYear) {
        $msg = "<p class='w3-red'>Geboortejaar mag niet hoger zijn dan huidig jaar</p>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO students (name, email, birth_year) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $birth]);
        $msg = "<p class='w3-green'>Student toegevoegd</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Student Toevoegen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Student Toevoegen</h2>

    <?= $msg ?>

    <form method="post" class="form">
        <label>Naam</label>
        <input name="name" placeholder="Naam" required>

        <label>Email</label>
        <input name="email" type="email" placeholder="Email" required>

        <label>Geboortejaar</label>
        <input name="birth_year" type="number" placeholder="Geboortejaar" required>

        <button class="button button-edit" type="submit">Opslaan</button>
        <a class="button button-back" href="index.php">Terug</a>
    </form>
</div>
</body>
</html>
