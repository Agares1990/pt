<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
include("include/_traduction.php");
session_start();
$css = "styleProfile";
$pdo = getPDO();

$email = $_SESSION['email'];
@$idReservation = $_POST['idReservation'];

// Récupérer le prenom du client pour afficher un message de Bienvenue
$client = $pdo->query("SELECT prenom FROM client WHERE email =  '$email'")->fetch();
//$client = $client->fetch();

// Afficher les réservation d'un client donné
$reservations = $pdo->query("SELECT * FROM reservation_chambre
                  LEFT JOIN nom_categorie_chambre ON reservation_chambre.categorieChambreId = nom_categorie_chambre.categorieChambreId
                  LEFT JOIN client ON reservation_chambre.clientId = client.idClient
                  WHERE email = '$email' && langueId = '$lang'");
if(isset($_POST['delete'])){

  //Requête pour supprimer une réservation
  $annulerReservation = $pdo->query("DELETE FROM reservation_chambre
                  WHERE clientId IN(SELECT clientId FROM (SELECT * FROM reservation_chambre) AS reserv INNER JOIN client ON reservation_chambre.clientId = client.idClient
                  WHERE email = '$email' && idReservationChambre = '$idReservation')");

// Actualiser la page après suppression d'une réservation
  $reservations = $pdo->query("SELECT * FROM reservation_chambre
                    LEFT JOIN nom_categorie_chambre ON reservation_chambre.categorieChambreId = nom_categorie_chambre.categorieChambreId
                    LEFT JOIN client ON reservation_chambre.clientId = client.idClient
                    WHERE email = '$email' && langueId = '$lang'");
  $messageSucces = "Votre réservation a bien été annuler";
}

echo $twig->render('profile.html.twig',
  	  array('css' => $css,
            'reservations'=> $reservations,
            'client' => $client,
            'messageSucces' => @$messageSucces
  				));
?>
