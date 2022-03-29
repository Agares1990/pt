<?php
  session_start();
  require "include/init_twig.php";
  require_once "include/_functions.php";
  $css = "style";
  $script = "script";

  $connection = getConnectionText();

  // Pour afficher l'heure et la témpérature
  date_default_timezone_set('Europe/Paris');
  $date = date("H:i");
  $localite = 'https://www.prevision-meteo.ch/services/json/NICE';
  $json = file_get_contents($localite);
  $json = json_decode($json);
  $temperature =  $json->current_condition->tmp;


  echo $twig->render('index.html.twig',
    	  array('css' => $css,
    	  			'date' => $date,
              'temperature' => " $temperature °C",
              'script' => $script,
              'connection' => $connection
    				));

?>
