<?php
session_start();
require "include/init_twig.php";
include_once("include/_connexion.php");
require_once "include/_functions.php";

$pdo = getPDO();
$lang = getLang();
@$email = $_SESSION['email'];

// Annuler une réservation restaurant
if (isset($_POST['deleteResaRestaurant'])) {
  $idReservationRestaurant = $_POST['idReservation'];
  $cancelResaRestaurant = cancelResaRestaurant($pdo, $idReservationRestaurant);

  // Afficher un message de success d'annulation réservation
  $messageSucces = "Votre réservation a bien été annuler";
  header("Location: profile.php?lang=$lang&messageSucces=$messageSucces");
  die();
}

?>
