<?php
require "include/init_twig.php";
require_once ("include/_connexion.php");
include("include/_traduction.php");
require_once "include/_functions.php";

session_start();
$css = "styleProfile";
$script = "profile";
$title = "Espace utilisateur";
$pdo = getPDO();
$lang = getLang();
$class_reservation = new Reservations();

$email = $_SESSION['email'];
$connection = getConnectionText($lang);
$langues = getIconLang($pdo);

if (!isset($_SESSION['email'])) {
  header("Location: connexion.php?lang=$lang");
  die();
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
      $class_reservation->cancelResa($pdo, $email, $idReservation);

      // Afficher un message de success d'annulation réservation
      $messageSucces = "Votre réservation a bien été annuler";
    }

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
        $errorMessage = "Veuillez entrez la date d'arrivée et la date de départ svp";
      }
      echo json_encode([ 'dateArriver' => $fromDate, 'dateDepart' => $toDate, 'price' => $roomsCheck['tarifCategorieChambre']*$nbDay,'idReservation' => $idReservation,'idChambre' => $roomsCheck['idChambre']]);
      exit(); // Arrêter l'execution de la scripte
    }

    // Appel de la fonction modifier reservation dans la classe Reservation
    $updateResa = $class_reservation->updateResa($pdo, $idReservation);
}


/////////////////////////////////
//Ajouter un Commentaire
$clientId = $client['idClient'];
if (isset($_POST['comment'])) {
  //if (!empty($_POST['title']) && !empty($_POST['note']) && !empty($_POST['comment'])) {// si les champnes ne sont pas vides
    // On va chercher les commentaires de l'utilisateur actuel
    if(empty(trim($_POST['title']))){
      echo 'Le titre est invalide';
      exit();
    }
    elseif(is_int($_POST['note']) && $_POST['note'] > 5){
      echo 'Veuillez entrer une note comprise entre 1 et 5';
      exit();
    }elseif (empty(trim($_POST['comment']))) {
      echo 'Veuillez donner votre avis svp';
      exit();
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
        $dateComment = date('Y-m-d');
        leaveComment($pdo, $clientId, $note, $title, $comment, $dateComment);
        echo json_encode(['messageComment' => "Votre commentaire a été bien ajouté", 'messageStyle' => 'messagePositive']);
        exit();
      }
    }
}
$dateNow = date('Y-m-d');
// Appel de la fonction récupérer les reservations dans la classe Reservation
$reservationsClient = $class_reservation->getClientResa($pdo, $email, $lang);
//print_r($reservationsClient[1]['dateArriver']);
// $reservationsClient['dateArriver'];


// Récupérer les réservation restaurant
$getResaRestaurants = getResaRestaurant($pdo, $email);

//Afficher le tableau de réservation restaurant s'il y a des réservations

if ($getResaRestaurants->rowCount() == 0) {
  $showTableResaRestaurant = 0;
} else{
  $showTableResaRestaurant = 1;
}


// Message d'annulation de réservation restaurant
if (isset($_GET['messageSucces'])) {
    $messageSucces =  "{$_GET['messageSucces']}";
}
  echo $twig->render('profile.html.twig',
        array('css' => $css,
              'script' => $script,
              'title' => $title,
              'lang' => $lang,
              'langues' => $langues,
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
              'dateComment' => @$dateComment,
              'errorMessage' => @$errorMessage,
              'updateResa' => @$updateResa,
              'dateNow' => @$dateNow,
              'getResaRestaurants' => @$getResaRestaurants,
              'showTableResaRestaurant' => @$showTableResaRestaurant,
              //Pour la traduction
              'nav1' => @$traductions[$lang]["nav1"],
              'nav2' => @$traductions[$lang]["nav2"],
              'nav3' => @$traductions[$lang]["nav3"],
              'nav4' => @$traductions[$lang]["nav4"],
              'nav5' => @$traductions[$lang]["nav5"],
              'profil' => @$traductions[$lang]["profil"],
              'connection' => $connection,
              'bienvenue' => @$traductions[$lang]["bienvenue"],
              'vosReservation' => @$traductions[$lang]["vosReservation"],
              'chambre' => @$traductions[$lang]["chambre"],
              'dateA' => @$traductions[$lang]["dateA"],
              'dateD' => @$traductions[$lang]["dateD"],
              'nbPersonPlaceholder' => @$traductions[$lang]["nbPerson"],
              'nbChildPlaceholder' => @$traductions[$lang]["nbChild"],
              'updateReservation' => @$traductions[$lang]["updateReservation"],
              'cancelReservation' => @$traductions[$lang]["cancelReservation"],
              'updateYour' => @$traductions[$lang]["updateYour"],
              'btnCheck' => @$traductions[$lang]["btnCheck"],
              'ttPay' => @$traductions[$lang]["ttPay"],
              'confirmUpdate' => @$traductions[$lang]["confirmUpdate"],
              'addComment' => @$traductions[$lang]["addComment"],
              'updatePwd' => @$traductions[$lang]["updatePwd"],
              'title' => @$traductions[$lang]["title"],
              'commentMessage' => @$traductions[$lang]["commentMessage"],
              'Mentions' => @$traductions[$lang]["Mentions"],
              'politic' => @$traductions[$lang]["politic"],
              'condition' => @$traductions[$lang]["condition"],
              'adress' => @$traductions[$lang]["adress"]

            ));


?>
