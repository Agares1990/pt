<?php
require "include/init_twig.php";
require "include/_connexion.php";
include("include/_traduction.php");
require_once "include/_functions.php";
session_start();
$css = "styleRecapReservation";
$pdo = getPDO();



if(isset($_POST['submit'])){

  $fromDate = $_POST["CheckIn"];
  $toDate = $_POST["CheckOut"];
  $idCategorieChambre = $_POST["idCategorieChambre"];
  $idRoom = $_POST["idChambre"];
  $roomType = $_POST["roomType"];
  $nbPerson = $_POST["nbPerson"];
  $nbChild = $_POST["nbChild"];
  $totalToPay = $_POST["totalToPay"];
  $nbDay = $_POST["nbDay"];
  @$dateCancel = date('Y-m-d', strtotime($fromDate. ' - 1 day'));

  $nom = $_POST["nom"];
  $prenom = $_POST["prenom"];
  $email = $_POST["email"];
  $mdp = $_POST["mdp"];
  $tel = $_POST["tel"];
  $pays = $_POST["pays"];
  $message = $_POST["message"];



  // if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($mdp) && !empty($tel) && !empty($pays)) {
    $checkMail = $pdo->query("SELECT * FROM client WHERE email = '$email'")->fetch();// Pour vérifier si l'utilisateur existe déjà
    //Le nom ne doit pas etre vide et doit contenir que des alphabet muniscule et majiscule
    if(!preg_match("/^([a-zA-Z' ]+)$/",$nom) || empty(trim($nom))){
      $fieldError = 'Le Nom invalide';
    }
    //Le prenom ne doit pas etre vide et doit contenir que des alphabet muniscule et majiscule
    elseif(!preg_match("/^([a-zA-Z' ]+)$/",$prenom) || empty(trim($prenom))){
      $fieldError = 'Le Prénom invalide';
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) || empty(trim($email))) {
      $fieldError = "L'email entré est invalide";
    }
    elseif($checkMail){
      $fieldError = "L'email saisi existe déjà";
    }
    elseif (empty(trim($mdp))) {
      $fieldError = "Veuillez entrez un mot de passe svp";
    }
    elseif (empty(trim($tel))) {
      $fieldError = "Veuillez entrez un numéro de téléphone valide svp";
    }
    else {
      $client = $pdo->prepare("INSERT INTO client(nom, prenom, email, mdp, tel, pays ) VALUES(?, ?, ?, ?, ?, ?)");
      $client->bindValue(1, $nom, PDO::PARAM_STR);
      $client->bindValue(2, $prenom, PDO::PARAM_STR);
      $client->bindValue(3, $email, PDO::PARAM_STR);
      $client->bindValue(4, password_hash($mdp, PASSWORD_DEFAULT), PDO::PARAM_STR);
      $client->bindValue(5, $tel, PDO::PARAM_STR);
      $client->bindValue(6, $pays, PDO::PARAM_STR);
      $client->execute();
      $idClient = $pdo->lastInsertId();

      $reservation = $pdo->prepare("INSERT INTO reservation_chambre(chambreId, categorieChambreId, clientId, dateArriver, dateDepart, nbPerson, nbChild, requeteSpeciale) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
      $reservation->bindParam(1, $idRoom, PDO::PARAM_STR);
      $reservation->bindParam(2, $idCategorieChambre, PDO::PARAM_STR);
      $reservation->bindParam(3, $idClient, PDO::PARAM_STR);
      $reservation->bindParam(4, $fromDate, PDO::PARAM_STR);
      $reservation->bindParam(5, $toDate, PDO::PARAM_STR);
      $reservation->bindParam(6, $nbPerson, PDO::PARAM_STR);
      $reservation->bindParam(7, $nbChild, PDO::PARAM_STR);
      $reservation->bindParam(8, $message, PDO::PARAM_STR);
      $reservation->execute();

      $_SESSION["email"] = $email;

    }
  }
var_dump($checkMail);
  // else {
  //   $fieldErreur = "il manque des infos";
  // }



  if (isset($fieldError)) {
    $_SESSION['erreur'] = $_POST; //on ouvre la session pour sauvegarder les données en cas d'erreur et les afficher dans la page formReservation
    header("Location: formReservation.php?message=$fieldError&nom=$nom&prenom=$prenom&email=$email&tel=$tel"); //Afficher le message d'erreur adéquat si il y a un ou des erreurs lors d'envoie du formulaire et garder les champs remplis
  }
// }
  $connection = getConnectionText();


echo $twig->render('recapReservation.html.twig',
  	  array('css' => $css,
            'connection' => $connection,
            'prenom' => $prenom,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'roomType' => $roomType,
            'nbPerson' => $nbPerson,
            'nbChild' => $nbChild,
            'nbDay' => $nbDay,
            'totalToPay' => $totalToPay,
            'dateCancel' => $dateCancel

  				));
?>
