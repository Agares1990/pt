<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
$pdo = getPDO();
$title = "Espace de connexion";
session_start();
session_unset();
session_destroy();
session_start();

$verifyConnection = verifyConnection($pdo, 'user', "manageReservation.php");

//$connection = getConnectionText();
echo $twig->render('indexBO.html.twig',
  	  array('verifyConnection' => @$verifyConnection,
            'title' => $title

  				));
?>
