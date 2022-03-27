<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
include("include/_traduction.php");
session_start();
$css = "styleProfile";
$pdo = getPDO();

$email = $_SESSION['email'];

$client = $pdo->query("SELECT prenom FROM client WHERE email =  '$email'")->fetch();
$client = $client["prenom"];

echo $twig->render('profile.html.twig',
  	  array('css' => $css,
            'client' => $client
  				));
?>
