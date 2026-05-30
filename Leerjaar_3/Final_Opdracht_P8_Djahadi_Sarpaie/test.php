<link rel="stylesheet" href="style.css">

<?php require 'db.php'; ?>

<table border="1">
<tr>
<th>Medewerker</th>
<th>Project</th>
<th>Uren</th>
<th>Tarief</th>
<th>Totaal</th>
<th>Approved</th>
<th>Acties</th>
</tr>

<?php
$sql = "SELECT w.*, e.name, p.project_name, p.hourly_rate
FROM worklogs w
JOIN employees e ON w.employee_id = e.id
JOIN projects p ON w.project_id = p.id";

$data = $pdo->query($sql);

$total_per_employee = [];

foreach ($data as $row) {
    $total = $row['hours_worked'] * $row['hourly_rate'];

    if ($row['approved'] == 'Ja') {
        if (!isset($total_per_employee[$row['name']])) {
            $total_per_employee[$row['name']] = 0;
        }
        $total_per_employee[$row['name']] += $total;
    }

    echo "<tr>
    <td>{$row['name']}</td>
    <td>{$row['project_name']}</td>
    <td>{$row['hours_worked']}</td>
    <td>{$row['hourly_rate']}</td>
    <td>$total</td>
    <td>{$row['approved']}</td>
    <td>
    <a href='worklog_edit.php?id={$row['id']}'>Edit</a>
    <a href='delete.php?type=worklog&id={$row['id']}'>Delete</a>
    </td>
    </tr>";
}
?>
</table>

<h3>Totaal per medewerker</h3>
<?php
foreach ($total_per_employee as $name => $sum) {
    echo "$name : $sum <br>";
}
?>