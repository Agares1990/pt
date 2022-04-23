<?php
require "include/init_twig.php";
require "include/_connexion.php";
include("include/_traduction.php");
require_once "include/_functions.php";
session_start();
$css = "styleFormReservation";
$script = "formReservation";
$pdo = getPDO();
$lang = getLang();
$langues = getIconLang($pdo);

@$email = $_SESSION['email'];
$connection = getConnectionText($lang);


//récupérer l'utilisateur actuel s'il est  déjà connecté
$client = $pdo->query("SELECT * FROM client WHERE email =  '$email'")->fetch();
$clientId = $client['idClient'];
if(isset($_POST['submit'])){
  $fromDate = $_POST["CheckIn"];
  $toDate = $_POST["CheckOut"];
  $nbPerson = $_POST["nbPerson"];
  $nbChild = $_POST["nbChild"];
  $roomType = $_POST["roomType"];
  $idRoom = $_POST["idChambre"];
  $idCategorieChambre = $_POST["idCategorieChambre"];
  $nbDay = $_POST["nbDay"];
  $totalToPay = $_POST["submit"];
  if (isset($_SESSION['email'])) { // si l'utilisateur déjà connecté, alors on effectue la réservation sans passer par le formulaire de réservation
    $reservation = $pdo->prepare("INSERT INTO reservation_chambre(chambreId, categorieChambreId, clientId, dateArriver, dateDepart, nbPerson, nbChild, requeteSpeciale) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
    $reservation->bindParam(1, $idRoom, PDO::PARAM_STR);
    $reservation->bindParam(2, $idCategorieChambre, PDO::PARAM_STR);
    $reservation->bindParam(3, $clientId, PDO::PARAM_STR);
    $reservation->bindParam(4, $fromDate, PDO::PARAM_STR);
    $reservation->bindParam(5, $toDate, PDO::PARAM_STR);
    $reservation->bindParam(6, $nbPerson, PDO::PARAM_STR);
    $reservation->bindParam(7, $nbChild, PDO::PARAM_STR);
    $reservation->bindParam(8, $message, PDO::PARAM_STR);
    $reservation->execute();
    header("Location: profile.php");
  }
}
//else if (isset($_SESSION['erreur'])){// S'il y a des erreurs
if (isset($_SESSION['erreur'])){// S'il y a des erreurs
  //on récupère les données de la session qui viennent du traitement de formulaire dans la page recapReservation

  $fromDate = $_SESSION['erreur']["CheckIn"];
  $toDate = $_SESSION['erreur']["CheckOut"];
  $roomType = $_SESSION['erreur']["roomType"];
  $idRoom = $_SESSION['erreur']["idChambre"];
  $idCategorieChambre = $_SESSION['erreur']["idCategorieChambre"];
  $nbPerson = $_SESSION['erreur']["nbPerson"];
  $nbChild = $_SESSION['erreur']["nbChild"];
  $nbDay = $_SESSION['erreur']["nbDay"];
  $totalToPay = $_SESSION['erreur']["totalToPay"];

  unset($_SESSION['erreur']); // on vide la session
}

if (isset($_GET['message'])) {// message d'erreur d'envoie d'un message à travers de la formulaire de contact en php
    $fieldError =  "{$_GET['message']}";
    $nom =  "{$_GET['nom']}";
    $prenom =  "{$_GET['prenom']}";
    $email =  "{$_GET['email']}";
    $tel =  "{$_GET['tel']}";
    $pays =  "{$_GET['pays']}";
}

echo $twig->render('formReservation.html.twig',
  	  array('css' => $css,
            'script' => $script,
            'lang' => $lang,
            'langues' => $langues,
            'connection' => $connection,
            'fromDate' => @$fromDate,
            'toDate' => @$toDate,
            'nbPerson' => @$nbPerson,
            'nbChild' => @$nbChild,
            'roomType' => @$roomType,
            'idRoom' => @$idRoom,
            'idCategorieChambre' => @$idCategorieChambre,
            'nbDay' => @$nbDay,
            'totalToPay' => @$totalToPay,
            'connection' => $connection,
            'fieldError' => @$fieldError,
            'nom' => @$nom,
            'prenom' => @$prenom,
            'email' => @$email,
            'tel' => @$tel,
            //Pour la traduction
            'nav1' => @$traductions[$lang]["nav1"],
            'nav2' => @$traductions[$lang]["nav2"],
            'nav3' => @$traductions[$lang]["nav3"],
            'nav4' => @$traductions[$lang]["nav4"],
            'nav5' => @$traductions[$lang]["nav5"],
            'profil' => @$traductions[$lang]["profil"],
            'connection' => $connection,
            'Mentions' => @$traductions[$lang]["Mentions"],
            'politic' => @$traductions[$lang]["politic"],
            'condition' => @$traductions[$lang]["condition"],
            'adress' => @$traductions[$lang]["adress"],
            'dateA' => @$traductions[$lang]["dateA"],
            'dateD' => @$traductions[$lang]["dateD"],
            'ttPay' => @$traductions[$lang]["ttPay"],
            'ttNight' => @$traductions[$lang]["ttNight"],
            'modifier' => @$traductions[$lang]["modifier"],
            'yrStay' => @$traductions[$lang]["yrStay"],
            'fillForm' => @$traductions[$lang]["fillForm"],
            "yrFstName" => @$traductions[$lang]["yrFstName"],
            "yrLstName" => @$traductions[$lang]["yrLstName"],
            "yrEmail" => @$traductions[$lang]["yrEmail"],
            "yrPwd" => @$traductions[$lang]["yrPwd"],
            "yrNumber" => @$traductions[$lang]["yrNumber"],
            "specReq" => @$traductions[$lang]["specReq"],
            "resa" => @$traductions[$lang]["resa"]
  				));

?>
