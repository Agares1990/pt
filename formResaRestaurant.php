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
$langues = getIconLang($pdo);

@$fromDate = $_GET['fromDate'];
@$hourResa = $_GET['hourResa'];
@$nbPerson = $_GET['nbPerson'];
@$idTable = $_GET['idTable'];

if (isset($_SESSION['erreur'])){// S'il y a des erreurs
  //on récupère les données de la session qui viennent du traitement de formulaire dans la page recapReservation

  $fromDate = $_SESSION['erreur']["CheckIn"];
  $hourResa = $_SESSION['erreur']["hourResa"];
  $nbPerson = $_SESSION['erreur']["nbPerson"];
  $idTable = $_SESSION['erreur']["idTable"];

  unset($_SESSION['erreur']); // on vide la session
}

if (isset($_GET['message'])) {// message d'erreur d'envoie d'un message à travers de la formulaire de contact en php
    $fieldError =  "{$_GET['message']}";
    $nom =  "{$_GET['nom']}";
    $prenom =  "{$_GET['prenom']}";
    $email =  "{$_GET['email']}";
    $tel =  "{$_GET['tel']}";
}
echo $twig->render('formResaRestaurant.html.twig',
  	  array('css' => $css,
            'connection' => $connection,
            'lang' => $lang,
            'langues' => $langues,
            'fromDate' => $fromDate,
            'hourResa' => $hourResa,
            'nbPerson' => $nbPerson,
            'idTable' => $idTable,
            'fieldError' => @$fieldError,
            'nom' => @$nom,
            'prenom' => @$prenom,
            'email' => @$email,
            'tel' => @$tel,
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
