<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
include("include/_traduction.php");
require_once "include/_functions.php";

session_start();
$css = "styleProfile";
$pdo = getPDO();

$connection = getConnectionText();
$email = $_SESSION['email'];
@$idReservation = $_POST['idReservation'];

// Récupérer le prenom du client pour afficher un message de Bienvenue
$client = $pdo->query("SELECT prenom FROM client WHERE email =  '$email'")->fetch();
//$client = $client->fetch();

// Afficher les réservation d'un client donné
$reservations = afficherReservationClient($pdo, $email, $lang);

//si on clique sur le bouton annuler
if(isset($_POST['delete'])){

  //On annule la réservation
  annulerReservation($pdo, $email, $idReservation);

// Actualiser la page après annulation d'une réservation
  $reservations = afficherReservationClient($pdo, $email, $lang);

  // Afficher un message de success d'annulation réservation
  $messageSucces = "Votre réservation a bien été annuler";
}



echo $twig->render('profile.html.twig',
  	  array('css' => $css,
            'reservations'=> $reservations,
            'client' => $client,
            'messageSucces' => @$messageSucces,
            'connection' => $connection
  				));
?>
