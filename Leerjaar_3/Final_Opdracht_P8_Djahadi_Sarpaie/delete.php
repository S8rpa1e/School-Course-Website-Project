<link rel="stylesheet" href="style.css">

<?php require 'db.php';
$type = $_GET['type'];
$id = $_GET['id'];

if ($type == 'employee') {
    $check = $pdo->prepare("SELECT COUNT(*) FROM worklogs WHERE employee_id=?");
    $check->execute([$id]);

    if ($check->fetchColumn() > 0) {
        echo "Kan niet verwijderen";
    } else {
        $pdo->prepare("DELETE FROM employees WHERE id=?")->execute([$id]);
        echo "Verwijderd";
    }
}

if ($type == 'project') {
    $check = $pdo->prepare("SELECT COUNT(*) FROM worklogs WHERE project_id=?");
    $check->execute([$id]);

    if ($check->fetchColumn() > 0) {
        echo "Kan niet verwijderen";
    } else {
        $pdo->prepare("DELETE FROM projects WHERE id=?")->execute([$id]);
        echo "Verwijderd";
    }
}

if ($type == 'worklog') {
    $pdo->prepare("DELETE FROM worklogs WHERE id=?")->execute([$id]);
    echo "Verwijderd";
}
?>