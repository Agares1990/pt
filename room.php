<?php
session_start();
require "include/init_twig.php";
require_once "include/_functions.php";

$css = "styleRoom";
$connection = getConnectionText();

echo $twig->render('room.html.twig',
  	  array('css' => $css,
            'connection' => $connection
  				));
?>
