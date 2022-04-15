<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "include/_functions.php";
$css = "styleEditPasswordClient";
$title = "Modifier le mot de passe";
$pdo = getPDO();
session_start();
$connection = getConnectionText();
$email = $_SESSION['email'];

if (isset($_GET['message'])) {// On récupére le message d'erreur en php
    $errorForm =  "{$_GET['message']}";
}


echo $twig->render('editPasswordClient.html.twig',
  	  array('css' => $css,
            'title' => $title,
            'errorForm' => @$errorForm,
            'connection' => $connection
  				));
?>
