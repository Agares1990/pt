<?php
session_start();
require "include/init_twig.php";
include_once("include/_traduction.php");
include_once("include/_connexion.php");
require_once "include/_functions.php";

$css = "styleFormResaRestaurant";
$pdo = getPDO();
$lang = getLang();
@$email = $_SESSION['email'];
$connection = getConnectionText($lang);

$fromDate = $_GET['fromDate'];
$hourResa = $_GET['hourResa'];
$nbPerson = $_GET['nbPerson'];
$idTable = $_GET['idTable'];

echo $twig->render('formResaRestaurant.html.twig',
  	  array('css' => $css,
            'connection' => $connection,
            'lang' => $lang,
            'fromDate' => $fromDate,
            'hourResa' => $hourResa,
            'nbPerson' => $nbPerson,
            'idTable' => $idTable,
            //Pour la traduction
            'nav1' => @$traductions[$lang]["nav1"],
            'nav2' => @$traductions[$lang]["nav2"],
            'nav3' => @$traductions[$lang]["nav3"],
            'nav4' => @$traductions[$lang]["nav4"],
            'nav5' => @$traductions[$lang]["nav5"],
            'profil' => @$traductions[$lang]["profil"],
            "yrFstName" => @$traductions[$lang]["yrFstName"],
            "yrLstName" => @$traductions[$lang]["yrLstName"],
            "yrEmail" => @$traductions[$lang]["yrEmail"],
            "yrPwd" => @$traductions[$lang]["yrPwd"],
            "yrNumber" => @$traductions[$lang]["yrNumber"],
            "specReq" => @$traductions[$lang]["specReq"],
            "resa" => @$traductions[$lang]["resa"],
            'Mentions' => @$traductions[$lang]["Mentions"],
            'politic' => @$traductions[$lang]["politic"],
            'condition' => @$traductions[$lang]["condition"],
            'adress' => @$traductions[$lang]["adress"]

  				));
?>
