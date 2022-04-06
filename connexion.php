<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
include("include/_traduction.php");
require_once "include/_functions.php";
$css = "styleConnexion";
$pdo = getPDO();
session_start();
session_unset();
session_destroy();
$verifyConnection = verifyConnection($pdo, 'client', 'profile.php');

$connection = getConnectionText();
echo $twig->render('connexion.html.twig',
  	  array('css' => $css,
            'connection' => $connection,
            'verifyConnection' => @$verifyConnection
  				));
?>
