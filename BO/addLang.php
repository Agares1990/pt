<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
require_once "include/_functionsBO.php";
$css = "styleAddLang";
$script = "addLang";
$title = "Ajouter une Langue";
$pdo = getPDO();

session_start();
@$prenomUser = $_SESSION["prenom"];
if (!isset($_SESSION['prenom'])) { // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header('Location: indexBO.php');
  die();
}

if (isset($_GET['message'])) {// On récupére le message d'erreur en php
    $sucessAddLang =  "{$_GET['message']}";
}

echo $twig->render('addLang.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'prenomUser' => $prenomUser,
            'title' => $title,
            'sucessAddLang' => @$sucessAddLang
  				));
?>
