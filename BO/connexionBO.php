<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
$pdo = getPDO();
session_start();
session_unset();
session_destroy();
if(!empty($_POST)){
  // Une fois on rempli et envoyé la formulaire, $_POST contient les information saisie sous forme d'un tableau associatif
  // Le formulaire à été envoyé
  // On vérifie que tous les champs requis sont remplis

  if (isset($_POST["email"], $_POST["mdp"]) && !empty($_POST["email"]) && !empty($_POST["mdp"])) {
    // On vérifie que c'est un email
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $errorConnection = "L'adresse mail est incorrecte";
    }
    $email = strip_tags($_POST['email']);
    $mdp =   strip_tags($_POST['mdp']);

    // On se connecte à la bdd
  //  $userExist = $db->query("SELECT * FROM users WHERE email =  '$email'")->fetch();

    $userExist = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $userExist->bindValue(":email", $email, PDO::PARAM_STR);
    $userExist->execute();
    $user = $userExist->fetch();
    // Si l'utilisateur n'existe pas
    if (!$user) {
      $errorConnection = "L'utilisateur et/ou le mot de passe est incorrect";
    }

    else{
      if(!password_verify($mdp, $user['mdp'])){

        $errorConnection = "L'utilisateur et/ou le mot de passe est incorrect";
      }

      else {

        // Ici l'utilisateur et le mot de passe sont corrects
        // On va pouvoir connecter l'utilisateur
        // On démarre la session PHP
        session_start();
        // On stock dans $_SESSION les information de l'utilisateur
        // $_SESSION["client"] = [ // à la place de client on peut mettre n'importe de quoi
          $_SESSION["email"] = $email;
        // ];
         // var_dump($_SESSION);
        // On redirige vers la page de profile
        header("Location: indexBO.php");
				  var_dump($_SESSION["email"]);
      }
    }

    // Ici on a un user existant, on vérifie son mote de passe
    // if(!password_verify($mdp, $userExist['pass'])){
    //   die ("Florian et Cindy sont passés par là");
     }

}

//$connection = getConnectionText();
echo $twig->render('connexionBO.html.twig',
  	  array('errorConnection' => @$errorConnection
  				));
?>
