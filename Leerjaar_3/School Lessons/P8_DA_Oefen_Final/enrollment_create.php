<?php
require 'db.php';
$msg = "";

// Haal alle studenten en cursussen op
$students = $pdo->query("SELECT id, name FROM students")->fetchAll(PDO::FETCH_ASSOC);
$courses = $pdo->query("SELECT id, course_name FROM courses")->fetchAll(PDO::FETCH_ASSOC);

// Formulier verstuurd
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $paid = isset($_POST['paid']) ? 1 : 0;

    // Check of inschrijving al bestaat
    $stmt = $pdo->prepare("SELECT * FROM enrollments WHERE student_id = ? AND course_id = ?");
    $stmt->execute([$student_id, $course_id]);
    if ($stmt->rowCount() > 0) {
        $msg = "<p class='w3-red'>Deze student is al ingeschreven voor deze cursus</p>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO enrollments (student_id, course_id, paid) VALUES (?, ?, ?)");
        $stmt->execute([$student_id, $course_id, $paid]);
        $msg = "<p class='w3-green'>Inschrijving succesvol toegevoegd!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inschrijving Toevoegen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Student Inschrijven voor Cursus</h2>

    <?= $msg ?>

    <form method="post" class="form">
        <label>Student</label>
        <select name="student_id" required>
            <option value="">-- Kies student --</option>
            <?php foreach($students as $s): ?>
                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Cursus</label>
        <select name="course_id" required>
            <option value="">-- Kies cursus --</option>
            <?php foreach($courses as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['course_name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>
            <input type="checkbox" name="paid"> Betaald
        </label>

        <button class="button button-edit" type="submit">Inschrijven</button>
         <a class="button button-back" href="index.php">Terug</button>
    </form>
</div>
</body>
</html>
