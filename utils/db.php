<?php
function dbConnect()
{
  try {
    $db = new PDO('mysql:host=localhost;dbname=football_french_championship', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    return $db;
  } catch(Exception $e) {
    $message = $e->getMessage();
    require('views/500.php');
    die;
  }
}

?>
