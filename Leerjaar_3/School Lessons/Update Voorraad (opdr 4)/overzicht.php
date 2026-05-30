<?php
include "db.php";

$sql = "SELECT product_id, productnaam, voorraad_aantal FROM voorraad";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Voorraad overzicht</title>
</head>
<body>
    <h1>Voorraad overzicht</h1>

    <table border="1" cellpadding="5">
        <tr>
            <th>Product</th>
            <th>Voorraad</th>
            <th>Actie</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['productnaam']) ?></td>
                <td><?= $row['voorraad_aantal'] ?></td>
                <td>
                    <a href="update_voorraad.php?id=<?= $row['product_id'] ?>">
                        Voorraad aanpassen
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
