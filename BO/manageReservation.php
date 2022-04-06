<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
require_once "include/_functionsBO.php";
$css = "styleManageReservation";
$pdo = getPDO();
session_start();
if (!isset($_SESSION['email'])) { // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header('Location: connexionBO.php');
}
$reservations = afficherReservationClientBO($pdo);

$connection = getConnectionText();
echo $twig->render('manageReservation.html.twig',
  	  array('css' => $css,
            'connection' => $connection,
            'reservations' => $reservations
  				));
?>
