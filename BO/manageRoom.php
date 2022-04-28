<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
require_once "include/_functionsBO.php";
$css = "styleManageRoom";
$script = "manageRoom";
$title = "Gérer les chambres";
$pdo = getPDO();
// $lang = 'fr';
session_start();
@$prenomUser = $_SESSION["prenom"];
if (!isset($_SESSION['prenom'])) { // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header('Location: indexBO.php');
}

// Pour supprimer une chambre
if(isset($_POST['delete'])){
  $chambreId = $_POST['idChambre'];
  //On supprime la chambre
  deleteRoom($pdo, $chambreId);

  // Afficher un message de success d'annulation réservation
  $messageSucces = "La chambre a été supprimer avec succès";
}

// Pour ajouter une chambre
if (isset($_POST['addRoom'])) {
  $numRoom = intval($_POST['numRoom']); // Numéro de la chambre
  $idRoomType = intval($_POST['idRoomType']);// Id de la categorie de la chambre
  $image = $_POST['image'];// Lien de l'image de la chambre
  $nbPerson = intval($_POST['nbPerson']); // Capacité d'adulte de la chambre
  $nbChild = intval($_POST['nbChild']); // Capacité d'enfant de la chambre

  // On vérifie si le numéro de chambre est déjà attribué à une autre chambre
  $checkRoomNumber = $pdo->query("SELECT * FROM chambre WHERE numChambre = '$numRoom'")->fetchAll();
  if ($checkRoomNumber) {
    $failedMessageAddUpdateRoom = "Le numéro de chambre existe déja";
  }
  elseif ($nbPerson > 5) {
    $failedMessageAddUpdateRoom = "La capacité d'acceuil doit être comprise entre 1 et 5";
  }
  elseif ($nbChild > 5) {
    $failedMessageAddUpdateRoom = "La capacité d'acceuil doit être comprise entre 0 et 5";
  }
  // Si toutes les données sont correctes
  // Alors on ajoute la chambre
  elseif (is_int($numRoom) && is_int($idRoomType) && is_int($nbPerson) && is_int($nbChild) && !empty(trim($image))) {

    $addRoom = $pdo->prepare("INSERT INTO chambre(numChambre, categorieChambreId, imageChambre, capaciteAdulte, capaciteEnfant ) VALUES(?, ?, ?, ?, ?)");
    $addRoom->bindValue(1, $numRoom, PDO::PARAM_STR);
    $addRoom->bindValue(2, $idRoomType, PDO::PARAM_STR);
    $addRoom->bindValue(3, $image, PDO::PARAM_STR);
    $addRoom->bindValue(4, $nbPerson, PDO::PARAM_STR);
    $addRoom->bindValue(5, $nbChild, PDO::PARAM_STR);
    $addRoom->execute();
    // On affiche un message de succès
    $succesMessageAddUpdateRoom = "La chambre a été ajouter avec succès";
  }
  // Sinon on affiche un message d'erreur
  else {
    $failedMessageAddUpdateRoom = "Erreur dans le/les valeur entrée";
  }

}
// si je clique sur le boutton modifier la chambre dans le tableau des chambre
if (isset($_POST['update'])) {
  $chambreId = $_POST['idChambre'];
  $getRoomInfo = $pdo->query("SELECT * FROM chambre WHERE idChambre ='$chambreId'")->fetch();// pour remplir par defaut les champs du formulaire de modification de chambre par les anciennes valeurs
}

if (isset($_POST['updateRoom'])) {
  $chambreId = $_POST['idChambre'];
  //$idRoomType = intval($_POST['idRoomType']);// Id de la categorie de la chambre
  $image = $_POST['image'];// Lien de l'image de la chambre
  $nbPerson = intval($_POST['nbPerson']); // Capacité d'adulte de la chambre
  $nbChild = intval($_POST['nbChild']); // Capacité d'enfant de la chambre

  if ($nbPerson > 5) {
    $failedMessageAddUpdateRoom = "La capacité d'acceuil doit être comprise entre 1 et 5";
  }
  elseif ($nbChild > 5) {
    $failedMessageAddUpdateRoom = "La capacité d'acceuil doit être comprise entre 0 et 5";
  }
  elseif (  is_int($nbPerson) && is_int($nbChild) && !empty(trim($image))) {

    $updateRoom = $pdo->prepare("UPDATE chambre SET  imageChambre = :imageChambre, capaciteAdulte = :capaciteAdulte, capaciteEnfant = :capaciteEnfant WHERE idChambre = $chambreId");

    $updateRoom->bindValue(':imageChambre', $image, PDO::PARAM_STR);
    $updateRoom->bindValue(':capaciteAdulte', $nbPerson, PDO::PARAM_STR);
    $updateRoom->bindValue(':capaciteEnfant', $nbChild, PDO::PARAM_STR);
    $updateRoom->execute();
    // On affiche un message de succès
    $succesMessageAddUpdateRoom = "La chambre a été modifier avec succès";
  }
  // Sinon on affiche un message d'erreur
  else {
    $failedMessageAddUpdateRoom = "Erreur dans le/les valeur entrée";
  }
}

// Pour gérer l'apparition du formulaire de modification de chambre
$update = 0;
if (isset($_POST['update'])) {
  $update = 1;
}

// Afficher toutes les chambre
$getRooms = $pdo->query("SELECT * FROM chambre ORDER BY numChambre");

echo $twig->render('manageRoom.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'prenomUser' => $prenomUser,
            'title' => $title,
            'getRooms' => $getRooms,
            'messageSucces' => @$messageSucces,
            'succesMessageAddUpdateRoom' => @$succesMessageAddUpdateRoom,
            'failedMessageAddUpdateRoom' => @$failedMessageAddUpdateRoom,
            'getRoomInfo' => @$getRoomInfo,
            'update' => $update


  				));
?>
