<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
include("include/_traduction.php");
require_once "include/_functions.php";
session_start();
$css = "styleCommentaire";
$script = "commentaire";
$pdo = getPDO();
$connection = getConnectionText();

$comments = getComments($pdo);
//$star = GenerateStars();
echo $twig->render('commentaire.html.twig',
  	  array('css' => $css,
            'connection' => $connection,
            'comments' => $comments,
            'star' => $star
  				));
?>
