<?php
  require "include/init_twig.php";
  include_once("include/_traduction.php");
  include_once("include/_connexion.php");
  $css = "styleContact";



  echo $twig->render('contact.html.twig',
    	  array('css' => $css,
              'lang' => $lang,
              'name' => $traductions[$lang]["inputName"],
              'mail' => $traductions[$lang]["inputMail"],
              'subject' => $traductions[$lang]["inputSubject"],
              'submit' => $traductions[$lang]["inputSubmit"]
    				));
?>
