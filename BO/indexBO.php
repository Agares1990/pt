<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
$css = "styleIndexBO";
$pdo = getPDO();
session_start();



$connection = getConnectionText();
echo $twig->render('indexBO.html.twig',
  	  array('css' => $css,
            'connection' => $connection
  				));
?>
