<link rel="stylesheet" href="style.css">

<?php require 'db.php';
$id = $_GET['id'];

$worklog = $pdo->prepare("SELECT * FROM worklogs WHERE id=?");
$worklog->execute([$id]);
$data = $worklog->fetch();

$projects = $pdo->query("SELECT * FROM projects")->fetchAll();
?>

<form method="POST">
Uren: <input type="number" name="hours" value="<?=$data['hours_worked']?>"><br>
Approved:
<select name="approved">
<option>Ja</option>
<option>Nee</option>
</select><br>
Project:
<select name="project">
<?php foreach($projects as $p){ ?>
<option value="<?=$p['id']?>"><?=$p['project_name']?></option>
<?php } ?>
</select><br>

<button type="submit">Opslaan</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $hours = $_POST['hours'];
    $approved = $_POST['approved'];
    $project = $_POST['project'];

    if ($hours < 1) {
        echo "Fout: uren >= 1";
    } else {
        $stmt = $pdo->prepare("UPDATE worklogs SET hours_worked=?, approved=?, project_id=? WHERE id=?");
        $stmt->execute([$hours,$approved,$project,$id]);
        echo "Geupdate";
    }
}
?>