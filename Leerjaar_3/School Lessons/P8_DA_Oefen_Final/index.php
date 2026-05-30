<?php
require 'db.php';

$sql = "
SELECT s.name AS student,
       c.course_name,
       (YEAR(CURDATE()) - s.birth_year) AS leeftijd,
       c.price,
       e.paid,
       s.id AS student_id,
       e.id AS enrollment_id
FROM enrollments e
JOIN students s ON e.student_id = s.id
JOIN courses c ON e.course_id = c.id
";

$data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Overzicht Inschrijvingen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Overzicht Inschrijvingen</h2>

    <div style="margin-bottom: 20px;">
        <a class="button button-edit" href="student_create.php">Student Toevoegen</a>
        

        <a class="button button-edit" href="course_create.php">Cursus Toevoegen</a>
        <a class="button button-edit" href="enrollment_create.php">Nieuwe Inschrijving</a>
    </div>

    <table>
        <tr>
            <th>Student</th>
            <th>Cursus</th>
            <th>Leeftijd</th>
            <th>Prijs</th>
            <th>Betaald</th>
            <th>Acties</th>
        </tr>

        <?php
        $totaal = [];
        foreach ($data as $row):
            $totaal[$row['student']] = ($totaal[$row['student']] ?? 0) + $row['price'];
        ?>
        <tr>
            <td><?= htmlspecialchars($row['student']) ?></td>
            <td><?= htmlspecialchars($row['course_name']) ?></td>
            <td><?= $row['leeftijd'] ?></td>
            <td>€<?= number_format($row['price'], 2) ?></td>
            <td><?= $row['paid'] ? 'Ja' : 'Nee' ?></td>
            <td>
                <a class="button button-edit" href="enrollment_edit.php?id=<?= $row['enrollment_id'] ?>">Bewerken</a>
                <a class="button button-delete" href="delete.php?enrollment=<?= $row['enrollment_id'] ?>">Verwijderen</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="total">
        <h3>Totaal per student</h3>
        <ul>
            <?php foreach ($totaal as $student => $bedrag): ?>
                <li><?= htmlspecialchars($student) ?>: €<?= number_format($bedrag, 2) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
</body>
</html>
