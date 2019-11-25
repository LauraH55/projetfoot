
<?php include('include/head.php')?>

<?php

$id = $_GET['id'];
require('utils/db.php');

$db = dbConnect();

$stmt = $db->prepare('SELECT * FROM teams WHERE id = :id');
$stmt->bindValue(':id', $id);
$stmt->execute();
$team = $stmt->fetch();

$date = new DateTime($team['fundation_date']);
echo $date->format('d-m-Y');


?>

<?= $team['name']; ?>
<?= $team['fundation_date']; ?>
<?= $team['president']; ?>

<?php include('include/footer.php') ?>
