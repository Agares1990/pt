<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
require_once "include/_functionsBO.php";
$css = "styleManageComment";
$script = "manageComment";
$title = "Gérer les commentaires";
$pdo = getPDO();
session_start();
@$prenomUser = $_SESSION["prenom"];
if (!isset($_SESSION['prenom'])) { // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header('Location: indexBO.php');
}


if (isset($_POST['delete'])) {
  $idComment = $_POST['idComment'];
  $deleteComment = deleteComment($pdo, $idComment);
}


// Récupérer les commentaires
$getComments = getComments($pdo);

echo $twig->render('manageComment.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'prenomUser' => $prenomUser,
            'title' => $title,
            'getComments' => $getComments,
            'deleteComment' => @$deleteComment
  				));
?>
