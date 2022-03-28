<?php
require "include/init_twig.php";
require "include/_connexion.php";

//$connection="Connexion";
//$session_status() == PHP_SESSION_ACTIVE
if(isset($_SESSION['email'])){
  $connection = "Deconnexion";
}
else{
  $connection = "Connexion";
}
var_dump($_SESSION['email']);
echo $twig->render('headerFooter.html.twig',
  	  array('connection' => $connection
  				));
?>
