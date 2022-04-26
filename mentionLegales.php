<?php
  session_start();
  require "include/init_twig.php";
  require "include/_traduction.php";
  require_once ("include/_connexion.php");
  require_once "include/_functions.php";
  $css = "styleMentionLegales";
  $title = "Mentions Légales & Copyright";
  $pdo = getPDO();
  $lang = getLang();
  $connection = getConnectionText($lang);
  $langues = getIconLang($pdo);

  echo $twig->render('mentionLegales.html.twig',
    	  array('css' => $css,
              'title' => $title,
              'lang' => $lang,
              'langues' => $langues,
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
              'connection' => $connection
    				));

?>
