<?php
require "include/init_twig.php";
require "include/_connexion.php";
include("include/_traduction.php");
require_once "include/_functions.php";
session_start();
$css = "styleRecapResaRestaurant";
$pdo = getPDO();
$lang = getLang();

@$email = $_SESSION['email'];
$connection = getConnectionText($lang);
$langues = getIconLang($pdo);


if(isset($_POST['submit'])){

  $fromDate = $_POST["CheckIn"];
  $hourResa = $_POST["hourResa"];
  $nbPerson = $_POST["nbPerson"];
  $idTable = $_POST["idTable"];

  $nom = $_POST["nom"];
  $prenom = $_POST["prenom"];
  $email = $_POST["email"];
  $mdp = $_POST["mdp"];
  $tel = $_POST["tel"];
  @$pays = $_POST["pays"];
  $message = $_POST["message"];



  // if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($mdp) && !empty($tel) && !empty($pays)) {
    $checkMail = $pdo->query("SELECT * FROM client WHERE email = '$email'")->fetch();// Pour vérifier si l'utilisateur existe déjà
    //Le nom ne doit pas etre vide et doit contenir que des alphabet muniscule et majiscule
    if(!preg_match("/^([a-zA-Z' ]+)$/",$nom) || empty(trim($nom))){
      $fieldError = 'Le Nom invalide';
    }
    //Le prenom ne doit pas etre vide et doit contenir que des alphabet muniscule et majiscule
    elseif(!preg_match("/^([a-zA-Z' ]+)$/",$prenom) || empty(trim($prenom))){
      $fieldError = 'Le Prénom invalide';
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) || empty(trim($email))) {
      $fieldError = "L'email entré est invalide";
    }
    elseif($checkMail){
      $fieldError = "L'email saisi existe déjà, connectez vous pour effectuer la réservation";
    }
    elseif (empty(trim($mdp))) {
      $fieldError = "Veuillez entrez un mot de passe svp";
    }
    elseif (empty(trim($tel))) {
      $fieldError = "Veuillez entrez un numéro de téléphone valide svp";
    }
    else {
      $client = $pdo->prepare("INSERT INTO client(nom, prenom, email, mdp, tel, pays ) VALUES(?, ?, ?, ?, ?, ?)");
      $client->bindValue(1, $nom, PDO::PARAM_STR);
      $client->bindValue(2, $prenom, PDO::PARAM_STR);
      $client->bindValue(3, $email, PDO::PARAM_STR);
      $client->bindValue(4, password_hash($mdp, PASSWORD_DEFAULT), PDO::PARAM_STR);
      $client->bindValue(5, $tel, PDO::PARAM_STR);
      $client->bindValue(6, $pays, PDO::PARAM_STR);
      $client->execute();
      $idClient = $pdo->lastInsertId();


      $resaRestaurant = $pdo->prepare("INSERT INTO reservation_restaurant(tableId, clientId, dateReservation, heureResa, nombrePersonne, requeteSpeciale) VALUES(?, ?, ?, ?, ?, ?)");
      $resaRestaurant->bindParam(1, $idTable, PDO::PARAM_STR);
      $resaRestaurant->bindParam(2, $idClient, PDO::PARAM_STR);
      $resaRestaurant->bindParam(3, $fromDate, PDO::PARAM_STR);
      $resaRestaurant->bindParam(4, $hourResa, PDO::PARAM_STR);
      $resaRestaurant->bindParam(5, $nbPerson, PDO::PARAM_STR);
      $resaRestaurant->bindParam(6, $message, PDO::PARAM_STR);

      $resaRestaurant->execute();

      $_SESSION["email"] = $email;

    }
  }


  if (isset($fieldError)) {
    $_SESSION['erreur'] = $_POST; //on ouvre la session pour sauvegarder les données en cas d'erreur et les afficher dans la page formResaRestaurant
    header("Location: formResaRestaurant.php?lang=$lang&message=$fieldError&nom=$nom&prenom=$prenom&email=$email&tel=$tel"); //Afficher le message d'erreur adéquat si il y a un ou des erreurs lors d'envoie du formulaire et garder les champs remplis
    die();
  }
// }


echo $twig->render('recapResaRestaurant.html.twig',
  	  array('css' => $css,
            'lang' => $lang,
            'langues' => $langues,
            'connection' => $connection,

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

  				));
?>
