<?php
session_start();
require "include/init_twig.php";
include("include/_connexion.php");
include("include/_traduction.php");
require_once "include/_functions.php";

$css = "styleFormCheckInPage";
$script = "formCheckInPage";
$lang = getLang();
$title = @$traductions[$lang]["btnCheck"]; // Afficher Vérifier la disponibilité comme titre de cette page

$pdo = getPDO();
$connection = getConnectionText($lang);
//$rooms = '';
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
      $errorCheck = "Veuillez choisir le nombre d'adulte svp";
    }
    elseif (!$nbChild) {
      $errorCheck = "Veuillez choisir le nombre d'enfant svp";
    }else {
      $where = "1 ";
      if ($roomType != 0) {// si on choisit une catégorie de chambre dans le formulaire
        $where = "";
        $where .= "chambre.categorieChambreId = ".$roomType;
      }
      $where .= " && capaciteAdulte >= " .$nbPerson;
      $where .= " && capaciteEnfant >= " . $nbChild ;
      $where .= " && idChambre NOT IN ( SELECT chambreId FROM reservation_chambre WHERE dateArriver BETWEEN '$fromDate' AND '$toDate' OR dateDepart BETWEEN '$fromDate' AND  '$toDate' )";

      // Récupérer les chambres dispo
       $rooms = getRooms($pdo, $lang, $where);

       if ($rooms->rowCount() == 0) {
         $messageCheck = "Désolé, il n'y a pas de disponibilité pour cette date";
       }
     }
  }
  if ($_POST['roomType']) {
    $showBtnOtherRoom = 1;
  }
  else {
    $showBtnOtherRoom = 0;
  }
  if (isset($_POST['otherRoom'])) {
    $fromDate = $_POST["CheckIn"];
    $toDate = $_POST["CheckOut"];
    $nbPerson = $_POST["nbPerson"];
    $nbChild = $_POST["nbChild"];
    @$roomType = $_POST["roomType"];
    $checkRoom = $_POST["checkRoom"]; // Vérifier si le formulaire renvoi 1 ou pas
    // $idCategorieChambre = $_POST["idCategorieChambre"];

    $fromDate = new DateTime($fromDate);
    $toDate = new DateTime($toDate);
    $nbDay =  date_diff($fromDate, $toDate);
    $nbDay = $nbDay->format('%a');

    $fromDate = $fromDate->format('Y-m-d');
    $toDate = $toDate->format('Y-m-d');
    var_dump($roomType);
    if ($roomType != 0) {// si on choisit une catégorie de chambre dans le formulaire
      //On affiche les autres chambres dispo quand on clique sur le boutton afficher d'autres chambres...
      $where = "chambre.categorieChambreId != " .$roomType;
      $where .= " && capaciteAdulte >= " .$nbPerson;
      $where .= " && capaciteEnfant >= " . $nbChild ;
      $where .= " && idChambre NOT IN ( SELECT chambreId FROM reservation_chambre WHERE dateArriver BETWEEN '$fromDate' AND '$toDate' OR dateDepart BETWEEN '$fromDate' AND  '$toDate' )";

       $otherRooms = getRooms($pdo, $lang, $where);
    }
    else {
      $messageOtherRooms = "Désolé, il n'y a pas d'autres chambres disponible dans ces dates, veuillez choisir une autre date";
    }

  }

  if (isset($errorCheck)) {
    $_SESSION['erreur'] = $_POST; //on ouvre la session pour sauvegarder les données en cas d'erreur et les afficher dans la page formCheckInPage
    header("Location: index.php?message=$errorCheck"); //Afficher le message d'erreur adéquat si il y a un ou des erreurs lors d'envoie du formulaire de CheckIn et garder les champs remplis
    die();
  }
// var_dump($otherRooms);
echo $twig->render('formCheckInPage.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'title' => $title,
            'lang' => $lang,
            'rooms' => @$rooms,
            'nbPerson' => @$nbPerson,
            'nbChild' => @$nbChild,
            'nbDay' => @$nbDay,
            'fromDate' => @$fromDate,
            'toDate' => @$toDate,
            'connection' => $connection,
            'messageCheck' => @$messageCheck,
            'otherRooms' => @$otherRooms,
            'roomType' => @$roomType,
            'checkRoom' =>@$checkRoom,
            'messageOtherRooms' => @$messageOtherRooms,
            'showBtnOtherRoom' => $showBtnOtherRoom,
            //Pour la traduction
            'nav1' => @$traductions[$lang]["nav1"],
            'nav2' => @$traductions[$lang]["nav2"],
            'nav3' => @$traductions[$lang]["nav3"],
            'nav4' => @$traductions[$lang]["nav4"],
            'nav5' => @$traductions[$lang]["nav5"],
            'profil' => @$traductions[$lang]["profil"],
            'connection' => $connection,
            'reserver' => @$traductions[$lang]["reserver"],
            'chambre' => @$traductions[$lang]["chambre"],
            'dateA' => @$traductions[$lang]["dateA"],
            'dateD' => @$traductions[$lang]["dateD"],
            'nbPersonPlaceholder' => @$traductions[$lang]["nbPerson"],
            'nbChildPlaceholder' => @$traductions[$lang]["nbChild"],
            'choixChambre' => @$traductions[$lang]["choixChambre"],
            'btnCheck' => @$traductions[$lang]["btnCheck"],
            'Mentions' => @$traductions[$lang]["Mentions"],
            'politic' => @$traductions[$lang]["politic"],
            'condition' => @$traductions[$lang]["condition"],
            'adress' => @$traductions[$lang]["adress"],

  				));
?>
