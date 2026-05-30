<?php
 include 'DatabaseConnect.php';

 $naam = "Arke";
$leeftijd = 48;
$opleiding = "WTB";

$sql_insert = "INSERT INTO studenten (naam, leeftijd, opleiding)
               VALUES ('$naam', $leeftijd, '$opleiding')";

if ($conn->query($sql_insert) === TRUE) {
    echo "Student succesvol toegevoegd!<br><br>";
} else {
    echo "Fout bij invoegen: " . $conn->error . "<br><br>";
}


$sql_select = "SELECT * FROM studenten";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    echo "Overzicht van studenten:";

    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["student_id"];
        echo "Naam: " . $row["naam"];
        echo "Leeftijd: " . $row["leeftijd"];
        echo "Opleiding: " . $row["opleiding"];

    }
} else {
    echo "Geen studenten gevonden.";
}


$conn->close();

?>