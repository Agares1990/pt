<?php
session_start();
require "include/init_twig.php";
$css = "styleRoom";

echo $twig->render('room.html.twig',
  	  array('css' => $css
  				));
?>
