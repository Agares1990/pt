<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
include("include/_traduction.php");
session_start();
$css = "styleProfile";
$pdo = getPDO();

$email = $_SESSION['email'];

$client = $pdo->query("SELECT prenom FROM client WHERE email =  '$email'")->fetch();
//$client = $client->fetch();


$reservations = $pdo->query("SELECT * FROM reservation_chambre
                  LEFT JOIN nom_categorie_chambre ON reservation_chambre.categorieChambreId = nom_categorie_chambre.categorieChambreId
                  LEFT JOIN client ON reservation_chambre.clientId = client.idClient
                  WHERE email = '$email' && langueId = '$lang'");

echo $twig->render('profile.html.twig',
  	  array('css' => $css,
            'reservations'=> $reservations,
            'client' => $client
  				));
?>
