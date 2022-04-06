<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
$css = "styleManageReservation";
$pdo = getPDO();
session_start();



$connection = getConnectionText();
echo $twig->render('manageReservation.html.twig',
  	  array('css' => $css,
            'connection' => $connection
  				));
?>
