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
@$idCategorieChambre = $_POST['idCategorieChambre'];

  // Récupérer le prenom du client pour afficher un message de Bienvenue
  $client = $pdo->query("SELECT * FROM client WHERE email =  '$email'")->fetch();
  //$client = $client->fetch();



  //si on clique sur le bouton annuler
  if(isset($_POST['delete'])){

    //On annule la réservation
    annulerReservation($pdo, $email, $idReservation);

  // // Actualiser la page après annulation d'une réservation
  //   $reservations = afficherReservationClient($pdo, $email, $lang);

    // Afficher un message de success d'annulation réservation
    $messageSucces = "Votre réservation a bien été annuler";
  }
  // Afficher les réservation d'un client donné
  $reservationsClient = afficherReservationClient($pdo, $email, $lang);


  if (isset($_POST['verify'])) {
    $fromDate = $_POST["CheckIn"];
    $toDate = $_POST["CheckOut"];
    $idCategorieChambre = $_POST["idCategorieChambre"];
    //var_dump($_POST);

    // Pour caculer le nombre de jours réservés
    $fromDate = new DateTime($fromDate);
    $toDate = new DateTime($toDate);
    $nbDay =  date_diff($fromDate, $toDate);
    $nbDay = $nbDay->format('%a');

    $fromDate = $fromDate->format('Y-m-d');
    $toDate = $toDate->format('Y-m-d');
    // echo $nbDay;

    if (!empty($fromDate) && !empty($toDate)) {
        $query = "SELECT * FROM chambre
        LEFT JOIN categorie_chambre ON chambre.categorieChambreId = categorie_chambre.idCategorieChambre
        WHERE idChambre NOT IN ( SELECT chambreId FROM reservation_chambre WHERE dateArriver BETWEEN '$fromDate' AND '$toDate' OR dateDepart BETWEEN '$fromDate' AND  '$toDate') AND chambre.categorieChambreId = '$idCategorieChambre'";  //requete pour récupérer les chambres dispo
        $roomsCheck = $pdo->query($query)->fetch();

      }
      // $tarifCategorieChambre = $roomsCheck['tarifCategorieChambre'];
      // print_r($tarifCategorieChambre);
  }
//   var_dump($query);
  // if (isset($_POST['updateResa'])) {
  // join client.idClient = reservation_chambre.clientId WHERE email = '$email'
  // }
  //


var_dump($idReservation);
var_dump($idCategorieChambre);

echo $twig->render('profile.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'reservations'=> $reservationsClient,
            'client' => $client,
            'messageSucces' => @$messageSucces,
            'connection' => $connection,
            'roomsCheck' => $roomsCheck,
            'idCategorieChambre' => $idCategorieChambre,
            'idReservation' => $idReservation,

            // 'nbPerson' => $nbPerson,
            // 'nbChild' => $nbChild,
            'nbDay' => $nbDay,


            'dateArriver' => $fromDate,
            'dateDepart' => $toDate
  				));
?>
