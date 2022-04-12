<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
require_once "include/_functionsBO.php";
$css = "styleCheckRoomBO";
$script = "checkRoomBO";
$title = "Chercher une chambre disponible";
$pdo = getPDO();
session_start();
@$prenomUser = $_SESSION["prenom"];
if (!isset($_SESSION['prenom'])) { // rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header('Location: indexBO.php');
}

if(isset($_POST['submit'])){

  $fromDate = $_POST["CheckIn"];
  $toDate = $_POST["CheckOut"];
  $nbPerson = $_POST["nbPerson"];
  $nbChild = $_POST["nbChild"];
  $roomType = $_POST["roomType"];
  //$idCategorieChambre = $_POST["idCategorieChambre"];

  // Pour caculer le nombre de jours réservés
  $fromDate = new DateTime($fromDate);
  $toDate = new DateTime($toDate);
  $nbDay =  date_diff($fromDate, $toDate);
  $nbDay = $nbDay->format('%a');

  $fromDate = $fromDate->format('Y-m-d');
  $toDate = $toDate->format('Y-m-d');


  // if (!empty($fromDate) && !empty($toDate) && !empty($nbPerson) && !empty($nbChild)) {
    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fromDate)) {
      $errorCheck = "Veuillez entrer une date d'arrivé valide (année-mois-jour)";
    }
    elseif (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $toDate)) {
      $errorCheck = "Veuillez entrer une date de départ valide (année-mois-jour)";
    }
    elseif (!$nbPerson) {
      $errorCheck = "Veuillez choisir le nombre d'adulte";
    }
    elseif (!$nbChild) {
      $errorCheck = "Veuillez choisir le nombre d'enfant";
    }else {
      $where = "1 ";
      if ($roomType != 0) {// si on choisit une catégorie de chambre dans le formulaire
        $where = "";
        $where .= "chambre.categorieChambreId = ".$roomType;
      }
      $where .= " && capaciteAdulte >= " .$nbPerson;
      $where .= " && capaciteEnfant >= " . $nbChild ;
      $where .= " && idChambre NOT IN ( SELECT chambreId FROM reservation_chambre WHERE dateArriver BETWEEN '$fromDate' AND '$toDate' OR dateDepart BETWEEN '$fromDate' AND  '$toDate' )";

       $query = "SELECT * FROM chambre
       LEFT JOIN categorie_chambre ON chambre.categorieChambreId = categorie_chambre.idCategorieChambre
       LEFT JOIN nom_categorie_chambre ON nom_categorie_chambre.categorieChambreId = categorie_chambre.idCategorieChambre
       && nom_categorie_chambre.langueId = '$lang'
       LEFT JOIN description_chambre ON chambre.idChambre = description_chambre.chambreId && description_chambre.langueId = '$lang'
       LEFT JOIN caracterestique_chambre ON categorie_chambre.idCategorieChambre = caracterestique_chambre.categorieChambreId && caracterestique_chambre.langueId = '$lang'
       WHERE  $where GROUP BY chambre.categorieChambreId"; // requete pour récupérer les chambres dispo
       $rooms = $pdo->query($query);

       if ($rooms->rowCount() == 0) {
         $messageCheck = "Désolé, il n'y a pas de disponibilité pour cette date";
       }
     }
  }

echo $twig->render('checkRoomBO.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'prenomUser' => $prenomUser,
            'rooms' => @$rooms,
            'nbPerson' => @$nbPerson,
            'nbChild' => @$nbChild,
            'nbDay' => @$nbDay,
            'fromDate' => @$fromDate,
            'toDate' => @$toDate,
            'messageCheck' => @$messageCheck,
            'title' => $title

  				));
?>
