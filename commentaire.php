<?php
require "include/init_twig.php";
require_once "include/_functions.php";
session_start();
$css = "styleCommentaire";
$script = "commentaire";

$connection = getConnectionText();
echo $twig->render('commentaire.html.twig',
  	  array('css' => $css,
            'connection' => $connection
  				));
?>
