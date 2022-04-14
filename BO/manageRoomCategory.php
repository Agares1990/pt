<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
require_once "include/_functionsBO.php";
$css = "styleManageRoomCategory";
$script = "manageRoomCategory";
$title = "Gérer les catégories de chambre";
$pdo = getPDO();
session_start();
@$prenomUser = $_SESSION["prenom"];
if (!isset($_SESSION['prenom'])) { // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header('Location: indexBO.php');
}

// si je clique sur le boutton modifier dans le tableau des catégories
if (isset($_POST['update'])) {
  $idCategorieChambre = $_POST['idCategorieChambre'];
  $getCategoryInfo = $pdo->query("SELECT * FROM categorie_chambre WHERE idCategorieChambre ='$idCategorieChambre'")->fetch();// pour remplir par defaut les champs du formulaire de modification de catégorie par les anciennes valeurs
}

if (isset($_POST['updateRoomCategory'])) {
  $idCategorieChambre = $_POST['idCategorieChambre'];// Id de la categorie de la chambre
  $tarifCategorieChambre = intval($_POST['tarifCategorieChambre']);// Tarif de la categorie de la chambre
  $image = $_POST['image'];// Lien de l'image de la catégorie

  if ( is_numeric($tarifCategorieChambre) && !empty(trim($image))) {
    $updateRoomCategory = $pdo->prepare("UPDATE categorie_chambre SET tarifCategorieChambre = :tarifCategorieChambre, image1 = :image WHERE idCategorieChambre = '$idCategorieChambre'");
    $updateRoomCategory->bindValue(':tarifCategorieChambre', $tarifCategorieChambre, PDO::PARAM_STR);
    $updateRoomCategory->bindValue(':image', $image, PDO::PARAM_STR);
    $updateRoomCategory->execute();
    // On affiche un message de succès
    $succesMessageAddUpdateRoom = "La catégorie a été modifier avec succès";
  }
  // Sinon on affiche un message d'erreur
  else {
    $failedMessageAddUpdateRoom = "Erreur dans le/les valeur entrée";
  }
}

// Pour gérer l'apparition du formulaire de modification de catégorie chambre
$updateCat = 0;
if (isset($_POST['updateCat'])) {
  $updateCat = 1;
}
// Pour récupérer tout les catégories de chambre
$getCategories = getCategories($pdo);
echo $twig->render('manageRoomCategory.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'prenomUser' => $prenomUser,
            'title' => $title,
            'getCategories' => $getCategories,
            'getCategoryInfo' => @$getCategoryInfo,
            'succesMessageAddUpdateRoom' => @$succesMessageAddUpdateRoom,
            'failedMessageAddUpdateRoom' => @$failedMessageAddUpdateRoom,
            'updateCat' => $updateCat

  				));
?>
