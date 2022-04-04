<?php
session_start();
require "include/init_twig.php";
include("include/_connexion.php");
include("include/_traduction.php");
require_once "include/_functions.php";

$css = "styleFormCheckInPage";

$pdo = getPDO();
$connection = getConnectionText();
//$rooms = '';
if(isset($_POST['submit'])){

  $fromDate = $_POST["CheckIn"];
  $toDate = $_POST["CheckOut"];
  $nbPerson = $_POST["nbPerson"];
  $nbChild = $_POST["nbChild"];
  $roomType = $_POST["roomType"];
  // $idCategorieChambre = $_POST["idCategorieChambre"];

  // Pour caculer le nombre de jours réservés
  $fromDate = new DateTime($fromDate);
  $toDate = new DateTime($toDate);
  $nbDay =  date_diff($fromDate, $toDate);
  $nbDay = $nbDay->format('%a');

  $fromDate = $fromDate->format('Y-m-d');
  $toDate = $toDate->format('Y-m-d');
  // echo $nbDay;

  if (!empty($fromDate) && !empty($toDate) && !empty($nbPerson) && !empty($nbChild)) {
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


    }
    // $count = $rooms->fetch();
    // var_dump($count);
    //$count = $rooms->fetch();
    //$count = $rooms->fetchColumn();
    //$rq = $rooms->rowCount();
    if ($rooms->rowCount() == 0) {
      $messageCheck = "Désolé, il n'y a pas de disponibilité selon vos critères";
    }
  }
//  var_dump($rooms);
      //print_r($count);
echo $twig->render('formCheckInPage.html.twig',
  	  array('css' => $css,
            'rooms' => $rooms,
            'nbPerson' => $nbPerson,
            'nbChild' => $nbChild,
            'nbDay' => $nbDay,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'connection' => $connection,
            'messageCheck' => @$messageCheck
  				));
?>
