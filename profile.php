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

if (!isset($_SESSION['email'])) {
  header('Location: connexion.php');
}
else {
  @$idReservation = $_POST['idReservation'];
  @$idCategorieChambre = $_POST['idCategorieChambre'];
  @$modification = $_POST['modification'];
    // Récupérer le prenom du client pour afficher un message de Bienvenue
    $client = $pdo->query("SELECT * FROM client WHERE email =  '$email'")->fetch();

    //si on clique sur le bouton annuler
    if(isset($_POST['delete'])){

      //On annule la réservation
      cancelResa($pdo, $email, $idReservation);

      // Afficher un message de success d'annulation réservation
      $messageSucces = "Votre réservation a bien été annuler";
    }
    // Afficher les réservation d'un client donné
    $reservationsClient = getClientResa($pdo, $email, $lang);

    // Vérifier la disponibilité quand on veut modifier une réservation
    if (isset($_POST['verify'])) {
      $fromDate = $_POST["CheckIn"];
      $toDate = $_POST["CheckOut"];
      $idCategorieChambre = $_POST["idCategorieChambre"];

      // Pour caculer le nombre de jours réservés
      $fromDate = new DateTime($fromDate);
      $toDate = new DateTime($toDate);
      $nbDay =  date_diff($fromDate, $toDate);
      $nbDay = $nbDay->format('%a');

      $fromDate = $fromDate->format('Y-m-d');
      $toDate = $toDate->format('Y-m-d');

      if (!empty($fromDate) && !empty($toDate)) {
          $query = "SELECT * FROM chambre
          LEFT JOIN categorie_chambre ON chambre.categorieChambreId = categorie_chambre.idCategorieChambre
          WHERE idChambre NOT IN ( SELECT chambreId FROM reservation_chambre WHERE dateArriver BETWEEN '$fromDate' AND '$toDate' OR dateDepart BETWEEN '$fromDate' AND  '$toDate') AND chambre.categorieChambreId = '$idCategorieChambre'";  //requete pour récupérer les chambres dispo
          $roomsCheck = $pdo->query($query)->fetch();
        }
      else {
        $errorMessage = "Veuillez entrez la date d'arriver et la date de départ svp";
      }
        //var_dump($roomsCheck);
    }

    // Fonction pour modifier reservation
    updateResa($pdo, $idReservation);
}

if (isset($_POST['verify']) && $_POST['verify'] == 1) {
  echo json_encode([ 'dateArriver' => $fromDate, 'dateDepart' => $toDate, 'price' => $roomsCheck['tarifCategorieChambre']*$nbDay,'idReservation' => $idReservation,'idChambre' => $roomsCheck['idChambre']]);
  exit(); // Arrêter l'execution de la scripte

}


/////////////////////////////////
//Ajouter un Commentaire
$clientId = $client['idClient'];
if (isset($_POST['comment'])) {
  //if (!empty($_POST['title']) && !empty($_POST['note']) && !empty($_POST['comment'])) {// si les champnes ne sont pas vides
    // On va chercher les commentaires de l'utilisateur actuel
    if(!preg_match("/^([a-zA-Z' ]+)$/",$_POST['title']) || empty(trim($_POST['title']))){
      $fieldError = 'Le titre est invalide';
    }
    elseif(is_int($_POST['note']) && $_POST['note'] > 5){
      $fieldError = 'Veuillez entrer une note comprise entre 1 et 5';
    }elseif (empty(trim($_POST['comment']))) {
      $fieldError = 'Veuillez donner votre avis svp';
    }
    else {
      $req = $pdo->prepare("SELECT * FROM commentaire WHERE clientId = :clientId");
      $req->bindParam(':clientId', $clientId, PDO::PARAM_INT);
      $req->execute();
      if (count($req->fetchAll())>0) {
        // On test si l'utilisateur a déjà poster un commentaire
        // Si oui on affiche un message 'messageComment'
        echo json_encode(['messageComment' => "Vous avez déja posté un commentaire", 'messageStyle' => 'messageNegative']);
        exit();
      }
      else{
        // Si non on poste le commentaire
        $title = htmlspecialchars($_POST['title']);
        $note = htmlspecialchars($_POST['note']);
        $comment = htmlspecialchars($_POST['comment']);
        $dateComment = date('Y-m-d');;
        leaveComment($pdo, $clientId, $note, $title, $comment, $dateComment);
        echo json_encode(['messageComment' => "Votre commentaire a été bien ajouté", 'messageStyle' => 'messagePositive']);
        exit();
      }
    }
}

$reservationsClient = getClientResa($pdo, $email, $lang);

  echo $twig->render('profile.html.twig',
        array('css' => $css,
              'script' => $script,
              'reservations'=> $reservationsClient,
              'client' => $client,
              'messageSucces' => @$messageSucces,
              'connection' => $connection,
              'roomsCheck' => @$roomsCheck,
              'idCategorieChambre' => $idCategorieChambre,
              'idReservation' => $idReservation,
              'modification' => $modification,
              'verify' => @$_POST['verify'],
              'nbDay' => @$nbDay,
              'dateArriver' => @$fromDate,
              'dateDepart' => @$toDate,
              'dateComment' => @$dateComment
            ));


?>
