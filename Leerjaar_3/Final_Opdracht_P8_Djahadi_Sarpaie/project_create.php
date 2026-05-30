<link rel="stylesheet" href="style.css">

<?php require 'db.php'; ?>

<form method="POST">
Naam: <input type="text" name="name"><br>
Tarief: <input type="number" step="0.01" name="rate"><br>
<button type="submit">Opslaan</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $rate = $_POST['rate'];

    if ($rate <= 0) {
        echo "Fout: tarief moet > 0";
    } else {
        $stmt = $pdo->prepare("INSERT INTO projects (project_name,hourly_rate) VALUES (?,?)");
        $stmt->execute([$name,$rate]);
        echo "Opgeslagen";
    }
}
?>