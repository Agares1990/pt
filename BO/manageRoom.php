<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
require_once "include/_functionsBO.php";
$css = "stylemanageRoom";
$script = "manageRoom";
$title = "Gérer les chambres";
$pdo = getPDO();
session_start();
@$prenomUser = $_SESSION["prenom"];
if (!isset($_SESSION['prenom'])) { // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header('Location: indexBO.php');
}
// Pour supprimer une chambre
if(isset($_POST['delete'])){
  $chambreId = $_POST['idChambre'];
  //On supprime la chambre
  deleteRoom($pdo, $chambreId);

  // Afficher un message de success d'annulation réservation
  $messageSucces = "La chambre a été supprimer avec succès";
}

$getRooms = $pdo->query("SELECT * FROM chambre");
echo $twig->render('manageRoom.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'prenomUser' => $prenomUser,
            'title' => $title,
            'getRooms' => $getRooms,
            'messageSucces' => @$messageSucces

  				));
?>
