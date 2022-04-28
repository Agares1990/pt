<?php
session_start();
require "include/init_twig.php";
include_once("include/_traduction.php");
include_once("include/_connexion.php");
require_once "include/_functions.php";

$pdo = getPDO();
$lang = getLang();

@$email = $_SESSION['email'];


if (isset($_POST['submit'])) {
  $fromDate = $_POST['CheckIn'];
  $hourResa = $_POST['hourResa'];
  $nbPerson = $_POST['nbPerson'];

  if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fromDate)) {
    $errorCheck = "Veuillez entrer une date valide (année-mois-jour)";
  }
  elseif (!$hourResa) {
    $errorCheck = "Veuillez choisir l'heure svp'";
  }
  elseif (!$nbPerson) {
    $errorCheck = "Veuillez choisir le nombre de personne svp";
  }


  // S'il y a des erreur dans le formulaire de recherche de disponibilité, on affiche le message adéquat
  if (isset($errorCheck)) {
    header("Location: restaurant.php?lang=$lang&errorForm=$errorCheck");
    die();
  }

  // Requête pour vérifier la disponibilité au restaurant
  $checkResaRestau = $pdo->query("SELECT * FROM restaurant WHERE capacite >= $nbPerson && idTable NOT IN ( SELECT tableId FROM reservation_restaurant WHERE dateReservation  = '$fromDate' && heureResa = '$hourResa')")->fetch();

  // Si la requête renvoie 0 resultat, alors on affiche un message
  if (!$checkResaRestau) {
    $messageCheck = "Désolé, il n'y a pas de disponibilité selon vos critères de recherche";
    header("Location: restaurant.php?lang=$lang&message=$messageCheck");
    die();
  }

    //récupérer l'utilisateur actuel s'il est  déjà connecté
    $client = $pdo->query("SELECT * FROM client WHERE email =  '$email'")->fetch();
    if ($client) {
      $clientId = $client['idClient'];
      header("Location: restaurant.php?lang=$lang&clientId=$clientId&idTable=$idTable&fromDate=$fromDate&hourResa=$hourResa&nbPerson=$nbPerson#valideResa");
      die();
    }
    else{
      $showBtnResaRestaurant = 0;
      $idTable = $checkResaRestau['idTable'];
      header("Location: formResaRestaurant.php?lang=$lang&idTable=$idTable&fromDate=$fromDate&hourResa=$hourResa&nbPerson=$nbPerson");
      die();
    }
  }
  // Sinon on affiche le formulaire de réservation
  // else {
  //   $idTable = $checkResaRestau['idTable'];
  //   header("Location: formResaRestaurant.php?lang=$lang&idTable=$idTable&fromDate=$fromDate&hourResa=$hourResa&nbPerson=$nbPerson");
  //   die();
  // }

?>
