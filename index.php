<?php
  session_start();
  require "include/init_twig.php";
  require "include/_connexion.php";
  require "include/_traduction.php";
  require_once "include/_functions.php";
  $css = "style";
  $script = "script";
  $pdo = getPDO();
  $lang = getLang();
  $title = "Nice ONE Resort & SPA";
  $connection = getConnectionText();
  $getTextTrad = getTextTrad($pdo, $lang);

  // Pour afficher l'heure et la témpérature
  date_default_timezone_set('Europe/Paris');
  $date = date("H:i");
  $localite = 'https://www.prevision-meteo.ch/services/json/NICE';
  $json = file_get_contents($localite);
  $json = json_decode($json);
  $temperature =  $json->current_condition->tmp;

  if (isset($_GET['message'])) {// message d'erreur  du formulaire de vérification de disponibilité
      $errorCheck =  "{$_GET['message']}";
  }
  $idImages = ["standardRoom", "familyRoom", "luxuryRoom", "suite"];
  echo $twig->render('index.html.twig',
    	  array('css' => $css,
              'script' => $script,
              'title' => $title,
              'lang' => $lang,
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
              'welcome' => @$traductions[$lang]["welcome"],
              'temperature' => " $temperature °C",
              'connection' => $connection,
              'getTextTrad' => $getTextTrad,
              'heure' => @$traductions[$lang]["heure"],
              'date' => $date,
              'errorCheck' => @$errorCheck

    				));

?>
