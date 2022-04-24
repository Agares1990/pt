<?php
session_start();
session_unset();
session_destroy();
session_start();
require "include/init_twig.php";
require_once ("include/_connexion.php");
include("include/_traduction.php");
require_once "include/_functions.php";
$css = "styleConnexion";
$pdo = getPDO();
$lang = getLang();
$langues = getIconLang($pdo);

$verifyConnection = verifyConnection($pdo, 'client', 'profile.php', $lang);

$connection = getConnectionText($lang);
echo $twig->render('connexion.html.twig',
  	  array('css' => $css,
            'lang' => $lang,
            'verifyConnection' => @$verifyConnection,
            'langues' => $langues,
            //Pour la traduction
            'nav1' => @$traductions[$lang]["nav1"],
            'nav2' => @$traductions[$lang]["nav2"],
            'nav3' => @$traductions[$lang]["nav3"],
            'nav4' => @$traductions[$lang]["nav4"],
            'nav5' => @$traductions[$lang]["nav5"],
            'profil' => @$traductions[$lang]["profil"],
            'connection' => $connection,
            'cnx' => @$traductions[$lang]["cnx"],
            'bienvenue' => @$traductions[$lang]["bienvenue"],
            'pwd' => @$traductions[$lang]["pwd"],
            'logIn' => @$traductions[$lang]["logIn"],
            'Mentions' => @$traductions[$lang]["Mentions"],
            'politic' => @$traductions[$lang]["politic"],
            'condition' => @$traductions[$lang]["condition"],
            'adress' => @$traductions[$lang]["adress"]

  				));
?>
