<?php
session_start();
require "include/init_twig.php";
include("include/_connexion.php");
require_once "../include/_functions.php";

$css = "styleResaRoomBO";
$script = "resaRoomBO";

$pdo = getPDO();
if(isset($_POST['submit'])){
  $fromDate = $_POST["CheckIn"];
  $toDate = $_POST["CheckOut"];
  $nbPerson = $_POST["nbPerson"];
  $nbChild = $_POST["nbChild"];
  $roomType = $_POST["roomType"];
  $idRoom = $_POST["idChambre"];
  $idCategorieChambre = $_POST["idCategorieChambre"];
  $nbDay = $_POST["nbDay"];
  $totalToPay = $_POST["totalToPay"];
  var_dump($idCategorieChambre);
  var_dump($idRoom);
}
if (isset($_POST['search'])) {
  $email = $_POST['recherche'];

  $fromDate = $_POST["CheckIn"];
  $toDate = $_POST["CheckOut"];
  $nbPerson = $_POST["nbPerson"];
  $nbChild = $_POST["nbChild"];
  $roomType = $_POST["roomType"];
  $idRoom = $_POST["idChambre"];
  $idCategorieChambre = $_POST["idCategorieChambre"];
  $nbDay = $_POST["nbDay"];
  $totalToPay = $_POST["totalToPay"];

  $searchClient = searchClientMail($pdo, $email);
  // if ($searchClient) {
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
// var_dump($otherRooms);
echo $twig->render('resaRoomBO.html.twig',
  	  array('css' => $css,
            'script' => $script,
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
            'tel' => @$tel
  				));
?>
