<?php
//On est ici si le client est déjà connecté au moment ou il check la disponibilité
session_start();
include_once("include/_connexion.php");
require_once "include/_functions.php";

$pdo = getPDO();
$lang = getLang();

if (isset($_POST['valideResa'])) {
  $fromDate = $_POST["fromDate"];
  $hourResa = $_POST["hourResa"];
  $nbPerson = $_POST["nbPerson"];
  $idTable = $_POST["idTable"];
  $clientId = $_POST["clientId"];

  $resaRestaurant = $pdo->prepare("INSERT INTO reservation_restaurant(tableId, clientId, dateReservation, heureResa, nombrePersonne, requeteSpeciale) VALUES(?, ?, ?, ?, ?, ?)");
  $resaRestaurant->bindParam(1, $idTable, PDO::PARAM_STR);
  $resaRestaurant->bindParam(2, $clientId, PDO::PARAM_STR);
  $resaRestaurant->bindParam(3, $fromDate, PDO::PARAM_STR);
  $resaRestaurant->bindParam(4, $hourResa, PDO::PARAM_STR);
  $resaRestaurant->bindParam(5, $nbPerson, PDO::PARAM_STR);
  $resaRestaurant->bindParam(6, $message, PDO::PARAM_STR);

  $resaRestaurant->execute();

  header("Location: recapResaRestaurant.php?lang=$lang");
  die();
}

 ?>
