<?php
session_start();
require "include/init_twig.php";
include_once("include/_traduction.php");
include_once("include/_connexion.php");
require_once "include/_functions.php";

$css = "styleEvent";
$pdo = getPDO();
$lang = getLang();
@$email = $_SESSION['email'];
$connection = getConnectionText($lang);
$langues = getIconLang($pdo);

echo $twig->render('event.html.twig',
  	  array('css' => $css,
            'connection' => $connection,
            'lang' => $lang,
            'langues' => $langues,
            //Pour la traduction
            'nav1' => @$traductions[$lang]["nav1"],
            'nav2' => @$traductions[$lang]["nav2"],
            'nav3' => @$traductions[$lang]["nav3"],
            'nav4' => @$traductions[$lang]["nav4"],
            'nav5' => @$traductions[$lang]["nav5"],
            'profil' => @$traductions[$lang]["profil"],
            'Mentions' => @$traductions[$lang]["Mentions"],
            'politic' => @$traductions[$lang]["politic"],
            'condition' => @$traductions[$lang]["condition"],
            'adress' => @$traductions[$lang]["adress"]
  				));
?>
