<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("<p class='w3-red'>Geen ID opgegeven!</p>");
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paid = $_POST['paid'];
    $course = $_POST['course_id'];

    $stmt = $pdo->prepare(
        "UPDATE enrollments SET paid = ?, course_id = ? WHERE id = ?"
    );
    $stmt->execute([$paid, $course, $id]);

    echo "<p class='w3-green'>Inschrijving bijgewerkt</p>";
}

$courses = $pdo->query("SELECT * FROM courses")->fetchAll();
?>

<form method="post" class="w3-card w3-container">
    <label>Betaald</label>
    <select name="paid" class="w3-select">
        <option value="1">Ja</option>
        <option value="0">Nee</option>
    </select><br><br>

    <label>Cursus</label>
    <select name="course_id" class="w3-select">
        <?php foreach ($courses as $c): ?>
            <option value="<?= $c['id'] ?>"><?= $c['course_name'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button class="w3-button w3-blue">Opslaan</button>
</form>
