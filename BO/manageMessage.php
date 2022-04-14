<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
require_once "include/_functionsBO.php";
$css = "styleManageMessage";
$title = "Gérer les messages reçus";
$pdo = getPDO();
session_start();
@$prenomUser = $_SESSION["prenom"];
if (!isset($_SESSION['prenom'])) { // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header('Location: indexBO.php');
}

// Supprimer un message
if (isset($_POST['delete'])) {
  $idMessage = $_POST['idMessage'];
  $deleteMessage = deleteMessage($pdo, $idMessage);
}

// Récupérer les messages
$getMessages = getMessages($pdo);

echo $twig->render('manageMessage.html.twig',
  	  array('css' => $css,
            'prenomUser' => $prenomUser,
            'getMessages' => $getMessages,
            'deleteMessage' => @$deleteMessage
  				));
?>
