<?php
include "db.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: overzicht.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nieuw_aantal = $_POST['voorraad_aantal'];

    $update = "UPDATE voorraad 
               SET voorraad_aantal = ? 
               WHERE product_id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("ii", $nieuw_aantal, $id);
    $stmt->execute();

    header("Location: overzicht.php");
    exit;
}

$sql = "SELECT productnaam, voorraad_aantal 
        FROM voorraad 
        WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Voorraad aanpassen</title>
</head>
<body>
    <h1>Voorraad aanpassen</h1>

    <p><strong>Product:</strong> <?= htmlspecialchars($product['productnaam']) ?></p>

    <form method="post">
        <label>
            Voorraad:
            <input type="number" name="voorraad_aantal"
                   value="<?= $product['voorraad_aantal'] ?>" required>
        </label>
        <br><br>
        <button type="submit">Opslaan</button>
    </form>

    <br>
    <a href="overzicht.php">Terug naar overzicht</a>
</body>
</html>
