<?php

require('utils/db.php');

$db = dbConnect();

$reponse = $db->prepare('SELECT * FROM teams');
$reponse->execute();
$teams = $reponse->fetchAll();
$reponse->closeCursor();


?>
<?php include('include/head.php')?>

<div class="container">
  <div class="row">
<?php foreach ($teams as $teamList) {

?>

    <div class="card-deck col-md-4 mt-5 carte">
      <div class="card">
        <img src="<?php echo $teamList['logo'];?>" class="card-img-top logo" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?php echo $teamList['name'];?></h5>
        </div>
      </div>
    </div>
<?php
  }
  ?>
</div>
  </div>
<?php include('include/footer.php') ?>




<!--
<?php

foreach($teams as $key => $value)
{
    echo $value['name'] . '<br />';
}
?>
-->
