<?php
require "include/init_twig.php";
$css = "styleConnexion";

echo $twig->render('connexion.html.twig',
  	  array('css' => $css
  				));
?>
