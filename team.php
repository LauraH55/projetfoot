
<?php include('include/head.php')?>

<?php

$idTeam = $_GET['id'];
require('utils/db.php');

$db = dbConnect();

$stmt = $db->prepare('SELECT * FROM teams WHERE id = :id');
$stmt->bindValue(':id', $idTeam);
$stmt->execute();
$team = $stmt->fetch();

$date = new DateTime($team['fundation_date']);

$stmt = $db->prepare('SELECT players.* , teams.name AS team_name, teams.id AS team_id, players_has_teams.number
  FROM `players`
  INNER JOIN players_has_teams
  ON players.id = players_has_teams.id_player
  INNER JOIN teams
  ON teams.id = players_has_teams.id_team
  WHERE teams.id = :id_team
  AND players_has_teams.number != 0
  ORDER BY players_has_teams.number');




$stmt->bindValue(':id_team', $idTeam);
$stmt->execute();
$players = $stmt->fetchAll();

$stmt = $db->prepare('SELECT matchs.*, th.name AS team_home_name, ta.name AS team_away_name
  FROM `matchs`
  INNER JOIN teams AS th
  ON matchs.id_team_home = th.id
  INNER JOIN teams AS ta
  ON matchs.id_team_away = ta.id
  WHERE th.id = :id_team OR ta.id = :id_team');

$stmt->bindValue(':id_team', $idTeam);
$stmt->execute();
$matchs = $stmt->fetchAll();




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
<div class="container">
  <div class="dropdown menudr">
    <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
     Effectif <?php echo $team['name']; ?>
    </button>
    <div class="collapse bg-light" id="collapseExample">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Numéro</th>
            <th scope="col">Name</th>
            <th scope="col">Date de naissance</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($players as $key => $player): ?>
            <tr>
              <td><?php echo $player['number']; ?></td>
              <td><?php echo $player['name']; ?></td>
              <td><?php echo $player['birthday_date']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="container">
  <div class="dropdown menudr">
    <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapseExample">
     Calendrier <?php echo $team['name']; ?>
    </button>
    <div class="collapse bg-light" id="collapse2">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Date</th>
            <th scope="col">Domicile</th>
            <th scope="col">Résultats</th>
            <th scope="col">Extérieur</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($matchs as $match): ?>
            <tr>
              <td><?php echo $match['date']; ?></td>
              <td><?php echo $match['team_home_name']; ?></td>
              <td><?php echo $match['score_home']; ?> - <?php echo $match['score_away']; ?></td>
              <td><?php echo $match['team_away_name']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>



<?php include('include/footer.php') ?>
