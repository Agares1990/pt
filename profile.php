<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
include("include/_traduction.php");
require_once "include/_functions.php";

session_start();
$css = "styleProfile";
$script = "profile";
$pdo = getPDO();

$connection = getConnectionText();
$email = $_SESSION['email'];
@$idReservation = $_POST['idReservation'];

// Récupérer le prenom du client pour afficher un message de Bienvenue
$client = $pdo->query("SELECT * FROM client WHERE email =  '$email'")->fetch();
//$client = $client->fetch();

// Afficher les réservation d'un client donné
$reservationsClient = afficherReservationClient($pdo, $email, $lang);

//si on clique sur le bouton annuler
if(isset($_POST['delete'])){

  //On annule la réservation
  annulerReservation($pdo, $email, $idReservation);

// Actualiser la page après annulation d'une réservation
  $reservations = afficherReservationClient($pdo, $email, $lang);

  // Afficher un message de success d'annulation réservation
  $messageSucces = "Votre réservation a bien été annuler";
}
if (isset($_POST['verify'])) {
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
     $where .= " && idChambre NOT IN ( SELECT chambreId FROM reservation_chambre WHERE dateArriver BETWEEN ".$fromDate ." AND " . $toDate ." or dateDepart BETWEEN " .$fromDate ." AND " . $toDate. ")";

      $query = "SELECT * FROM chambre
      LEFT JOIN categorie_chambre ON chambre.categorieChambreId = categorie_chambre.idCategorieChambre
      LEFT JOIN nom_categorie_chambre ON nom_categorie_chambre.categorieChambreId = categorie_chambre.idCategorieChambre
      && nom_categorie_chambre.langueId = '$lang'
      LEFT JOIN description_chambre ON chambre.idChambre = description_chambre.chambreId && description_chambre.langueId = '$lang'
      LEFT JOIN caracterestique_chambre ON categorie_chambre.idCategorieChambre = caracterestique_chambre.categorieChambreId && caracterestique_chambre.langueId = '$lang'
      WHERE  $where GROUP BY chambre.categorieChambreId"; // requete pour récupérer les chambres dispo
      $rooms = $pdo->query($query);
    }
}
if (isset($_POST['updateResa'])) {
  annulerReservation($pdo, $email, $idReservation);

  $fromDate = $_POST["CheckIn"];
  $toDate = $_POST["CheckOut"];
  $idCategorieChambre = $_POST["idCategorieChambre"];
  $idRoom = $_POST["idChambre"];
  $roomType = $_POST["roomType"];
  $nbPerson = $_POST["nbPerson"];
  $nbChild = $_POST["nbChild"];
  $idClient = $client["idClient"];

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

// echo $reservationsClient["idReservation"];


echo $twig->render('profile.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'reservations'=> $reservationsClient,
            'client' => $client,
            'messageSucces' => @$messageSucces,
            'connection' => $connection,
            'rooms' => $rooms,
            'nbPerson' => $nbPerson,
            'nbChild' => $nbChild,
            'nbDay' => $nbDay,
            'fromDate' => $fromDate,
            'toDate' => $toDate
  				));
?>
