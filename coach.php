<?php include('include/head.php')?>

<?php

$idCoach = $_GET['id'];
require('utils/db.php');

$db = dbConnect();


$stmt = $db->prepare('SELECT
  c.*,
  t.id AS tid,
  t.name AS tname,
  t.logo AS tlogo
  FROM coachs AS c
  INNER JOIN coachs_has_teams as cht
  ON cht.id_coach = c.id
  INNER JOIN teams as t
  ON t.id = cht.id_team
  WHERE c.id = :id');

  $stmt->bindValue(':id', $idCoach);
  $stmt->execute();
  $team = $stmt->fetch();

$date = new DateTime($team['birthday_date']);

?>

<div class="container description" style="color: black;">
  <div class="row">
    <div class="col-md-8" style="font-family: 'Dosis', sans-serif;">
      <h1><?php echo $team['name']; ?></h1>
      <img  class="pic" src="<?php echo $team['photo'];?>" alt="photo entraineur"><img  class="trainer" src="<?php echo $team['tlogo'];?>" alt="logo">
      <p>Nom : <strong><?php echo $team['name']; ?></strong></p>
      <p>Date de naissance : <strong><?php echo $date->format('d/m/Y'); ?></strong></p>
      <p>Pays : <strong><?php echo $team['nationality']; ?></strong></p>

    </div>
  </div>
</div>































<?php include('include/footer.php') ?>
