<?php
function dbConnect()
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=football_french_championship', 'root', '');
    return $db;
  } catch(Exception $e) {
    $message = $e->getMessage();
    require('views/500.php');
    die;
  }
}

?>
