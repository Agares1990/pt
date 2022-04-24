<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
include("include/_traduction.php");
require_once "include/_functions.php";
session_start();
$css = "styleCommentaire";
$script = "commentaire";
$pdo = getPDO();
$lang = getLang();
$connection = getConnectionText($lang);
$langues = getIconLang($pdo);

$comments = getComments($pdo);
$getTextTrad = getTextTrad($pdo, $lang);

echo $twig->render('commentaire.html.twig',
  	  array('css' => $css,
            'connection' => $connection,
            'comments' => $comments,
            'getTextTrad' => $getTextTrad,
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
            'adress' => @$traductions[$lang]["adress"],
            'clientReviews' => @$traductions[$lang]["clientReviews"],
            'welcome' => @$traductions[$lang]["welcome"],
            'YrRevieuw' => @$traductions[$lang]["YrRevieuw"],
            'titlePage' => @$traductions[$lang]["titlePage"],
  				));
?>
