<?php
require "include/init_twig.php";
require "include/_connexion.php";
include("include/_traduction.php");
$css = "recapReservation";
$pdo = getPDO();
if(isset($_POST['submit'])){

  $fromDate = $_POST["CheckIn"];
  $toDate = $_POST["CheckOut"];
  $idCategorieChambre = $_POST["idCategorieChambre"];
  $idRoom = $_POST["idChambre"];
  $roomType = $_POST["roomType"];
  $nbPerson = $_POST["nbPerson"];
  $nbChild = $_POST["nbChild"];

  $nom = $_POST["nom"];
  $prenom = $_POST["prenom"];
  $mail = $_POST["mail"];
  $mdp = $_POST["mdp"];
  $tel = $_POST["tel"];
  $pays = $_POST["pays"];
  $message = $_POST["message"];

  if (!empty($nom) && !empty($prenom) && !empty($mail) && !empty($mdp) && !empty($tel) && !empty($pays)) {

    $client = $pdo->prepare("INSERT INTO client(nom, prenom, email, mdp, tel, pays ) VALUES(?, ?, ?, ?, ?, ?)");
    $client->bindValue(1, $nom, PDO::PARAM_STR);
    $client->bindValue(2, $prenom, PDO::PARAM_STR);
    $client->bindValue(3, $mail, PDO::PARAM_STR);
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
echo $twig->render('recapReservation.html.twig',
  	  array('css' => $css,
  				));
?>
