<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
$pdo = getPDO();
session_start();
session_unset();
session_destroy();
session_start();

$verifyConnection = verifyConnection($pdo, 'user', "manageReservation.php");
$email = $_SESSION["email"];
var_dump($_SESSION);
//$connection = getConnectionText();
echo $twig->render('indexBO.html.twig',
  	  array('verifyConnection' => @$verifyConnection,
            'email' => $email

  				));
?>
