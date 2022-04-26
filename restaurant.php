<?php
session_start();
require "include/init_twig.php";
include_once("include/_traduction.php");
include_once("include/_connexion.php");
require_once "include/_functions.php";

$css = "styleRestaurant";
$pdo = getPDO();
$lang = getLang();
@$email = $_SESSION['email'];
$connection = getConnectionText($lang);
$langues = getIconLang($pdo);

if (isset($_GET['errorForm'])) {
    $errorForm =  "{$_GET['errorForm']}";
}
elseif (isset($_GET['message'])) {
    $message =  "{$_GET['message']}";
}
elseif (isset($_GET['clientId'])) {
    $clientId =  "{$_GET['clientId']}";
    $idTable =  "{$_GET['idTable']}";
    $fromDate =  "{$_GET['fromDate']}";
    $hourResa =  "{$_GET['hourResa']}";
    $nbPerson =  "{$_GET['nbPerson']}";
    $showBtnResaRestaurant = 1;
}


echo $twig->render('restaurant.html.twig',
  	  array('css' => $css,
            'connection' => $connection,
            'lang' => $lang,
            'langues' => $langues,
            'message' => @$message,
            'errorCheck' => @$errorCheck,
            'clientId' => @$clientId,
            'idTable' => @$idTable,
            'fromDate' =>  @$fromDate,
            'hourResa' =>  @$hourResa,
            'nbPerson' =>  @$nbPerson,
            'showBtnResaRestaurant' => @$showBtnResaRestaurant,

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
            'btnCheck' => @$traductions[$lang]["btnCheck"],
            'resaRestaurant' => @$traductions[$lang]["resaRestaurant"]

  				));
?>
