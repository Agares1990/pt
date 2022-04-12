<?php
session_start();
require "include/init_twig.php";
include("include/_connexion.php");
require_once "../include/_functions.php";

$css = "styleResaRoomBO";
$script = "resaRoomBO";
$title = "Réserver chambre";
$pdo = getPDO();
@$prenomUser = $_SESSION["prenom"];
if (!isset($_SESSION['prenom'])) { // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header('Location: indexBO.php');
}

if(isset($_POST['submit'])){ // si je clique sur le submite de formulaire de recherche de chambre
  //Je récupère les données envoyès par le formulaire de recherch de chambre
  $fromDate = $_POST["CheckIn"];
  $toDate = $_POST["CheckOut"];
  $nbPerson = $_POST["nbPerson"];
  $nbChild = $_POST["nbChild"];
  $roomType = $_POST["roomType"];
  $idRoom = $_POST["idChambre"];
  $idCategorieChambre = $_POST["idCategorieChambre"];
  $nbDay = $_POST["nbDay"];
  $totalToPay = $_POST["totalToPay"];
}
if (isset($_POST['search'])) { // si je clique sur le submite de formulaire de recherche client (par email)
  $email = $_POST['recherche']; // je récupère l'email saisi
//Je récupère les données envoyès par le formulaire de recherch de client
  $fromDate = $_POST["CheckIn"];
  $toDate = $_POST["CheckOut"];
  $nbPerson = $_POST["nbPerson"];
  $nbChild = $_POST["nbChild"];
  $roomType = $_POST["roomType"];
  $idRoom = $_POST["idChambre"];
  $idCategorieChambre = $_POST["idCategorieChambre"];
  $nbDay = $_POST["nbDay"];
  $totalToPay = $_POST["totalToPay"];

  $searchClient = searchClientMail($pdo, $email);// je vérifie si l'email existe dans la base de données
  // if ($searchClient) {
    // s'il existe, je récupère les informations liées à ce client
    $idClient = $searchClient['idClient'];
    $nom = $searchClient['nom'];
    $prenom = $searchClient['prenom'];
    $email = $searchClient['email'];

    $response = [ 'totalToPay' => $totalToPay, 'roomType' => $roomType, 'nbDay' => $nbDay, 'idClient' => @$idClient, 'nom' => @$nom, 'prenom' => @$prenom, 'email' => @$email, 'fromDate' => @$fromDate, 'toDate' => @$toDate, 'nbPerson' => @$nbPerson, 'nbChild' =>
    @$nbChild, 'idCategorieChambre' => @$idCategorieChambre, 'idRoom' => @$idRoom];
    echo json_encode($response);
    exit; // Arrêter l'execution de la scripte
  // }
  // else {
  //   echo json_encode([ 'totalToPay' => $totalToPay, 'roomType' => $roomType, 'nbDay' => $nbDay, 'fromDate' => @$fromDate, 'toDate' => @$toDate, 'nbPerson' => @$nbPerson, 'nbChild' =>
  //   @$nbChild, 'idCategorieChambre' => @$idCategorieChambre, 'idRoom' => @$idRoom ]);
  //   exit;
  // }
}
if (isset($_GET['message'])) {// message d'erreur d'envoie d'un message à travers de la formulaire de contact en php
    $fieldError =  "{$_GET['message']}";
}
// var_dump($otherRooms);
echo $twig->render('resaRoomBO.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'prenomUser' => $prenomUser,
            'nbPerson' => @$nbPerson,
            'nbChild' => @$nbChild,
            'nbDay' => @$nbDay,
            'fromDate' => @$fromDate,
            'toDate' => @$toDate,
            'roomType' => @$roomType,
            'idRoom' => @$idRoom,
            'idCategorieChambre' => @$idCategorieChambre,
            'totalToPay' => @$totalToPay,
            'nom' => @$nom,
            'prenom' => @$prenom,
            'email' => @$email,
            'tel' => @$tel,
            'fieldError' => @$fieldError,
            'title' => $title
  				));
?>
