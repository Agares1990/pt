<?php
  session_start();
  require "include/init_twig.php";
  require "include/_traduction.php";
  require_once "include/_functions.php";
  $css = "stylePolitiqueConfidentialite";
  $lang = getLang();
  $title = "Politique de confidentialité";

  $connection = getConnectionText();
  echo $twig->render('politiqueConfidentialite.html.twig',
    	  array('css' => $css,
              'title' => $title,
              'lang' => $lang,
              'nav1' => @$traductions[$lang]["nav1"],
              'nav2' => @$traductions[$lang]["nav2"],
              'nav3' => @$traductions[$lang]["nav3"],
              'nav4' => @$traductions[$lang]["nav4"],
              'nav5' => @$traductions[$lang]["nav5"],
              'profil' => @$traductions[$lang]["profil"],
              'connection' => $connection,
    				));

?>
