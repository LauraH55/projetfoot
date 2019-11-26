
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


?>


<div class="container description" style="color: black;">
  <div class="row">
    <div class="col-md-8">
      <h1><?php echo $team['name']; ?></h1>
      <img src="<?php echo $team['logo'];?>" alt="">
      <p>Nom : <?php echo $team['name']; ?> </p>
      <p>Fondé en : <?php echo $date->format('d/m/Y'); ?> </p>
      <p>Président : <?php echo $team['president']; ?></p>
    </div>
  </div>
</div>



<?php include('include/footer.php') ?>
