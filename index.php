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
  $connection = getConnectionText($lang);
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
  // $where = "idCategorieChambre = 1 && idCategorieChambre = 2 && idCategorieChambre = 3 && idCategorieChambre = 4";
  $getRooms = getRooms($pdo, $lang, 1);
  echo $twig->render('index.html.twig',
    	  array('css' => $css,
              'script' => $script,
              'title' => $title,
              'lang' => $lang,
              'temperature' => " $temperature °C",
              'connection' => $connection,
              'getTextTrad' => $getTextTrad,
              'date' => $date,
              'errorCheck' => @$errorCheck,
              'getRooms' => $getRooms,
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
              'welcome' => @$traductions[$lang]["welcome"],
              'heure' => @$traductions[$lang]["heure"],
              'Mentions' => @$traductions[$lang]["Mentions"],
              'politic' => @$traductions[$lang]["politic"],
              'condition' => @$traductions[$lang]["condition"],
              'adress' => @$traductions[$lang]["adress"],
              'eventRoom' => @$traductions[$lang]["eventRoom"]
    				));

?>
