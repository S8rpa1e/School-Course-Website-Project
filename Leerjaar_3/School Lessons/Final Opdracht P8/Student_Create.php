<?php

include 'Db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Naam = $_POST['naam'];
    $Email = $_POST['email'];
    $Geboortejaar = $_POST['geboortejaar'];
    $huidigJaar = date("Y");

    if($Geboortejaar > $huidigJaar){
        $message = "Geboortejaar mag niet hoger zijn dan huidig jaar.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO students (Naam,Email,Geboortejaar) VALUES (?, ?, ?)");
        $stmt->execute([$Naam,$Email,$Geboortejaar]);
        $message = "Student succesvol toegevoegd!";
    }
}

?>
<form method="post">
    Naam: <input type="text" name="naam" required><br>
    Email: <input type="email" name="email" required><br>
    Geboortejaar: <input type="number" name="geboortejaar" required><br>
    <button type="submit">Toevoegen</button>
</form>
