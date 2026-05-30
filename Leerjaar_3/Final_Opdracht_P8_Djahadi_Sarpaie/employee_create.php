<link rel="stylesheet" href="style.css">

<?php require 'db.php'; ?>

<form method="POST">
Naam: <input type="text" name="name"><br>
Email: <input type="text" name="email"><br>
Jaar: <input type="number" name="year"><br>
<button type="submit">Opslaan</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $year = $_POST['year'];
    $current = date("Y");

    if ($year > $current) {
        echo "Fout: jaar klopt niet";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Fout: email ongeldig";
    } else {
        $stmt = $pdo->prepare("INSERT INTO employees (name,email,hire_year) VALUES (?,?,?)");
        $stmt->execute([$name,$email,$year]);
        echo "Opgeslagen";
    }
}
?>