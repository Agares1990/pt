<?php
session_start();
require "include/init_twig.php";
include_once("include/_traduction.php");
include_once("include/_connexion.php");
require_once "include/_functions.php";

$css = "styleRoom";
$pdo = getPDO();
$lang = getLang();
@$email = $_SESSION['email'];
$connection = getConnectionText($lang);
echo $twig->render('room.html.twig',
  	  array('css' => $css,
            'connection' => $connection,
            //Pour la traduction
            'nav1' => @$traductions[$lang]["nav1"],
            'nav2' => @$traductions[$lang]["nav2"],
            'nav3' => @$traductions[$lang]["nav3"],
            'nav4' => @$traductions[$lang]["nav4"],
            'nav5' => @$traductions[$lang]["nav5"],
            'profil' => @$traductions[$lang]["profil"],
            'connection' => $connection,
            'reserver' => @$traductions[$lang]["reserver"],
            'chambre' => @$traductions[$lang]["chambre"],
            'dateA' => @$traductions[$lang]["dateA"],
            'dateD' => @$traductions[$lang]["dateD"],
            'nbPersonPlaceholder' => @$traductions[$lang]["nbPerson"],
            'nbChildPlaceholder' => @$traductions[$lang]["nbChild"],
            'choixChambre' => @$traductions[$lang]["choixChambre"],
            'btnCheck' => @$traductions[$lang]["btnCheck"],
            'Mentions' => @$traductions[$lang]["Mentions"],
            'politic' => @$traductions[$lang]["politic"],
            'condition' => @$traductions[$lang]["condition"],
            'adress' => @$traductions[$lang]["adress"]
  				));
?>
