<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "account_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql_select = "SELECT * FROM gebruikers";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "ID ". $row["gebruiker_id"] .",  ";
    echo "Naam ". $row["naam"] .",  ";
    echo "Email ". $row["email"] .",  ";
    echo "Status ". $row["status"] .",  ";
  }
}

#update stuk

echo "user dat geupdate worden";

$update = "UPDATE gebruikers Set status = ? WHERE gebruiker_id = ?";
$stmt = $conn->prepare($update);
$status = "Inactief";
$id = 1;
$stmt-> bind_param("si", $status, $id);
$stmt->execute();

echo "<h2>Gebruikers na update</h2>";

$result = $conn->query($sql_select);

while ($row = $result->fetch_assoc()) {
    echo "ID " . $row["gebruiker_id"] . ", ";
    echo "Status " . $row["status"] . "<br>";
}

$stmt->close();
$conn->close();
?>
?>