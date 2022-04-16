<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
include("include/_traduction.php");
require_once "include/_functions.php";
$css = "styleConnexion";
$pdo = getPDO();
$lang = getLang();
session_start();
session_unset();
session_destroy();
session_start();
$verifyConnection = verifyConnection($pdo, 'client', 'profile.php');

$connection = getConnectionText();
echo $twig->render('connexion.html.twig',
  	  array('css' => $css,
            'nav1' => @$traductions[$lang]["nav1"],
            'nav2' => @$traductions[$lang]["nav2"],
            'nav3' => @$traductions[$lang]["nav3"],
            'nav4' => @$traductions[$lang]["nav4"],
            'nav5' => @$traductions[$lang]["nav5"],
            'profil' => @$traductions[$lang]["profil"],
            'connection' => $connection,
            'verifyConnection' => @$verifyConnection
  				));
?>
