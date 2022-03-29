<?php
require "include/init_twig.php";
require_once "include/_functions.php";
session_start();
$css = "styleEvent";

$connection = getConnectionText();
echo $twig->render('event.html.twig',
  	  array('css' => $css,
            'connection' => $connection
  				));
?>
