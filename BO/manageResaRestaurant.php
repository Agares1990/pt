<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
require_once "include/_functionsBO.php";
$css = "styleManageResaRestaurant";
$title = "Gérer les réservation restaurant";
$pdo = getPDO();
session_start();
@$prenomUser = $_SESSION["prenom"];
if (!isset($_SESSION['prenom'])) { // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header('Location: indexBO.php');
}

// Supprimer une réservation
if (isset($_POST['delete'])) {
  $idReservationRestaurant = $_POST['idReservation'];
  $cancelResaRestaurant = $pdo->query("DELETE FROM reservation_restaurant
                  WHERE clientId IN(SELECT clientId FROM (SELECT * FROM reservation_restaurant) AS reserv INNER JOIN client ON reservation_restaurant.clientId = client.idClient
                  WHERE idReservationRestaurant = '$idReservationRestaurant')");
}

$dateNow = date('Y-m-d');
// Récupérer les réservation
$getResaRestaurants = $pdo->query("SELECT * FROM reservation_restaurant
                  JOIN client ON reservation_restaurant.clientId = client.idClient
                  ")->fetchAll();

echo $twig->render('manageResaRestaurant.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'prenomUser' => $prenomUser,
            'title' => $title,
            'getResaRestaurants' => $getResaRestaurants,
            'cancelResaRestaurant' => @$cancelResaRestaurant,
            'dateNow' => $dateNow
  				));
?>
