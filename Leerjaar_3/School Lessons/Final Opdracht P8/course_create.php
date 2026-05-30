<?php
require 'db.php';
$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $cursusnaam = $_POST['cursusnaam'];
    $prijs = $_POST['prijs'];

    if($prijs <= 0){
        $message = "Prijs moet groter zijn dan 0.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO courses (CourseName,Prijs) VALUES (?,?)");
        $stmt->execute([$cursusnaam,$prijs]);
        $message = "Cursus succesvol toegevoegd!";
    }
}
?>

<form method="post">
    Cursusnaam: <input type="text" name="cursusnaam" required><br>
    Prijs: <input type="number" step="0.01" name="prijs" required><br>
    <button type="submit">Toevoegen</button>

    <p><?= $msg ?? '' ?></p>
    
</form>

<p><?= $message ?></p>