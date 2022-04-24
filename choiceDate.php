<?php
  require "include/init_twig.php";
  include_once("include/_traduction.php");
  include_once("include/_connexion.php");
  require_once "include/_functions.php";
  session_start();
  $css = "styleChoiceDate";
  $title = "Choisir une date";
  $pdo = getPDO();
  $lang = getLang();
  @$email = $_SESSION['email'];
  $connection = getConnectionText($lang);
  $langues = getIconLang($pdo);

if (isset($_POST['reserver'])) {
  $nbPerson = $_POST['nbPerson'];
  $nbChild = $_POST['nbChild'];
  $roomType = $_POST['roomType'];
}

  echo $twig->render('choiceDate.html.twig',
    	  array('css' => $css,
              'script' => $script,
              'connection' => $connection,
              'lang' => $lang,
              'title' => $title,
              'langues' => $langues,
              'nbPerson' => @$nbPerson,
              'nbChild' => @$nbChild,
              'roomType' => @$roomType,
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
              'btnCheck' => @$traductions[$lang]["btnCheck"]
    				));
?>
