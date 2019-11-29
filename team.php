
<?php include('include/head.php')?>

<?php

$idTeam = $_GET['id'];
require('utils/db.php');

$db = dbConnect();

$stmt = $db->prepare('SELECT
  t.*,
  s.id AS sId,
  s.name AS sName,
  s.capacity,
  s.adress AS sAdress,
  s.tel
  FROM teams AS t
  INNER JOIN stadiums as s
  WHERE t.id = :id');
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

$req = 'SELECT matchs.*, th.name AS team_home_name, ta.name AS team_away_name
  FROM `matchs`
  INNER JOIN teams AS th
  ON matchs.id_team_home = th.id
  INNER JOIN teams AS ta
  ON matchs.id_team_away = ta.id
  WHERE (th.id = :id_team OR ta.id = :id_team)';

$stmt = $db->prepare($req . ' AND matchs.score_home IS NOT NULL');
$stmt->bindValue(':id_team', $idTeam);
$stmt->execute();
$matchsPlayed = $stmt->fetchAll();

$stmt = $db->prepare($req . ' AND matchs.score_home IS NULL');
$stmt->bindValue(':id_team', $idTeam);
$stmt->execute();
$matchsNotPlayed = $stmt->fetchAll();





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
          <tr style="font-family: 'Dosis', sans-serif;">
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
              <td><?php echo (new DateTime($player['birthday_date']))->format('d/m/Y'); ?></td>
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
          <tr style="font-family: 'Dosis', sans-serif;">
            <th scope="col">Domicile</th>
            <th scope="col">Résultats</th>
            <th scope="col">Extérieur</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($matchsPlayed as $match): ?>
            <tr>
              <td><?php echo $match['team_home_name']; ?></td>
              <td><?php echo $match['score_home']; ?> - <?php echo $match['score_away']; ?></td>
              <td><?php echo $match['team_away_name']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <h3 style="font-family: 'Dosis', sans-serif;">Rencontres à venir</h3>
      <table class="table">
        <thead class="thead-dark">
          <tr style="font-family: 'Dosis', sans-serif;">
            <th scope="col">Domicile</th>
            <th scope="col">Date</th>
            <th scope="col">Extérieur</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($matchsNotPlayed as $match): ?>
            <tr>
              <td><?php echo $match['team_home_name']; ?></td>
                <td><?php echo $match['date']; ?></td>
              <td><?php echo $match['team_away_name']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="container">
  <div class="dropdown menudr">
    <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapseExample">
     Administratif <?php echo $team['name']; ?>
    </button>
    <div class="collapse bg-light" id="collapse3">
      <table style="font-family: 'Dosis', sans-serif;" class="table">
            <tr scope="col"> <td>Site : <strong><?php echo $team['website']; ?></strong></td> </tr>
            <tr scope="col"><td>Siège : <strong><?php echo $team['adress']; ?></strong></td></tr>
          </table>
    </div>
  </div>
</div>
<div class="container">
  <div class="dropdown menudr">
    <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapseExample">
     Stade <?php echo $team['name']; ?>
    </button>
    <div class="collapse bg-light" id="collapse4">
      <table style="font-family: 'Dosis', sans-serif;" class="table">
          <tr style="font-family: 'Dosis', sans-serif;">
            <tr scope="col"> <td>Stade : <strong><?php echo $team['sName']; ?></strong></td></tr>
            <tr scope="col"> <td>Capacité : <strong><?php echo $team['capacity']; ?></strong></td></tr>
            <tr scope="col"> <td>Adresse du stade : <strong><?php echo $team['sAdress']; ?></strong></td></tr>
            <tr scope="col"> <td>Tél. Stade : <strong><?php echo $team['tel']; ?></strong></td></tr>
          </tr>
      </table>
    </div>
  </div>
</div>




<?php include('include/footer.php') ?>
