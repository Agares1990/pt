<?php
session_start();
require "include/init_twig.php";
include("include/_connexion.php");
require_once "../include/_functions.php";

$css = "styleRecapReservationBO";
$script = "resaRoomBO";
$pdo = getPDO();
@$prenomUser = $_SESSION["prenom"];
if (!isset($_SESSION['prenom'])) { // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header('Location: indexBO.php');
}

if(isset($_POST['reserver'])){

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

    }
  }
  if (isset($fieldError)) {
    header("Location: resaRoomBO.php?message=$fieldError"); //Afficher le message d'erreur adéquat si il y a un ou des erreurs lors d'envoie du formulaire et garder les champs remplis
  }

// Si on trouve le client par le biais de la barre de recherche, on effectue la réservation directement quand on clique sur le button réserver (afficher par ajax)
  // $client = searchClientMail($pdo, $email); // Récupérer les données du client trouvé
  // $clientId = $client['idClient'];
  if(isset($_POST['valideClientResa'])){
    $clientId = $_POST["idClient"];
    $fromDate = $_POST["CheckIn"];
    $toDate = $_POST["CheckOut"];
    $nbPerson = $_POST["nbPerson"];
    $nbChild = $_POST["nbChild"];
    $idRoom = $_POST["idChambre"];
    $idCategorieChambre = $_POST["idCategorieChambre"];
    $roomType = $_POST["roomType"];
    $nbDay = $_POST["nbDay"];
    $totalToPay = $_POST["totalToPay"];

    $reservation = $pdo->prepare("INSERT INTO reservation_chambre(chambreId, categorieChambreId, clientId, dateArriver, dateDepart, nbPerson, nbChild, requeteSpeciale) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
    $reservation->bindParam(1, $idRoom, PDO::PARAM_STR);
    $reservation->bindParam(2, $idCategorieChambre, PDO::PARAM_STR);
    $reservation->bindParam(3, $clientId, PDO::PARAM_STR);
    $reservation->bindParam(4, $fromDate, PDO::PARAM_STR);
    $reservation->bindParam(5, $toDate, PDO::PARAM_STR);
    $reservation->bindParam(6, $nbPerson, PDO::PARAM_STR);
    $reservation->bindParam(7, $nbChild, PDO::PARAM_STR);
    $reservation->bindParam(8, $message, PDO::PARAM_STR);
    $reservation->execute();
  }

// var_dump($otherRooms);
echo $twig->render('recapReservationBO.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'prenomUser' => $prenomUser,
            'fromDate' => @$fromDate,
            'toDate' => @$toDate,
            'roomType' => @$roomType,
            'nbPerson' => @$nbPerson,
            'nbChild' => @$nbChild,
            'nbDay' => @$nbDay,
            'totalToPay' => @$totalToPay,
            'dateCancel' => @$dateCancel
  				));
?>
