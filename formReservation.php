<?php
require "include/init_twig.php";
require "include/_connexion.php";
include("include/_traduction.php");
require_once "include/_functions.php";
session_start();
$css = "styleFormReservation";
$script = "formReservation";
$pdo = getPDO();
$connection = getConnectionText();
@$email = $_SESSION['email'];

//récupérer l'utilisateur actuel s'il est  déjà connecté
$client = $pdo->query("SELECT * FROM client WHERE email =  '$email'")->fetch();
$clientId = $client['idClient'];
if(isset($_POST['submit'])){
  $fromDate = $_POST["CheckIn"];
  $toDate = $_POST["CheckOut"];
  $nbPerson = $_POST["nbPerson"];
  $nbChild = $_POST["nbChild"];
  $roomType = $_POST["roomType"];
  $idRoom = $_POST["idChambre"];
  $idCategorieChambre = $_POST["idCategorieChambre"];
  $nbDay = $_POST["nbDay"];
  $totalToPay = $_POST["submit"];
  if (isset($_SESSION['email'])) { // si l'utilisateur déjà connecté, alors on effectue la réservation sans passer par le formulaire de réservation
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
    header("Location: profile.php");
  }
}
echo $twig->render('formReservation.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'nbPerson' => $nbPerson,
            'nbChild' => $nbChild,
            'roomType' => $roomType,
            'idRoom' => $idRoom,
            'idCategorieChambre' => $idCategorieChambre,
            'nbDay' => $nbDay,
            'totalToPay' => $totalToPay,
            'connection' => $connection
  				));
?>
