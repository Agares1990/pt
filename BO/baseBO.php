<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
session_start();
$pdo = getPDO();
if(isset($_SESSION['email'])){
  $email = $_SESSION["email"];
}
else {
  echo "Erreur de connexion";
}
var_dump($_SESSION);

$currentUser = $pdo->query("SELECT * FROM user WHERE email = '$email'")->fetch();
var_dump($currentUser);

//$connection = getConnectionText();
echo $twig->render('baseBO.html.twig',
  	  array('currentUser' => @$currentUser['prenom']
  				));
?>
