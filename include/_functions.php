<?php
/** Pour changer la langue **/
function getLang(){
  if ( isset ($_GET['lang'] ) )
  $lang = $_GET['lang'];
  else {
  $lang = 'fr';
  }
  return $lang;
}
// Fonction pour savoir si l'utilisateur est connecté ou pas
function getConnectionText($lang){
  if(isset($_SESSION['email']) && @$lang == 'fr'){
    $connection = "Deconnexion";
  }elseif (isset($_SESSION['email']) && @$lang == 'en') {
    $connection = "Logout";
  }elseif (isset($_SESSION['email']) && @$lang == 'it') {
    $connection = "Disconnettersi";
  }
  elseif (!isset($_SESSION['email']) && @$lang == 'fr') {
    $connection = "Connexion";
  }
  elseif (!isset($_SESSION['email']) && @$lang == 'it') {
    $connection = "Login";
  }
  else{
    $connection = "Login";
  }
  return $connection;
}

// Afficher les icones de langue
function getIconLang($pdo){
  $getIconLang = $pdo->query("SELECT * FROM langue");
  return $getIconLang;
}
// Récupérer du texte de la bdd selon la langue
function getTextTrad($pdo, $lang){
  $getTextTrad = $pdo->query("SELECT * FROM texte WHERE langueId = '$lang'")->fetch();
  return $getTextTrad;
}

class Reservations
{
  // Fonction pour afficher les réservations dans l'espace client
  public function getClientResa($pdo, $email, $lang){
    $reservations = $pdo->query("SELECT * FROM reservation_chambre
                      LEFT JOIN nom_categorie_chambre ON reservation_chambre.categorieChambreId = nom_categorie_chambre.categorieChambreId
                      LEFT JOIN client ON reservation_chambre.clientId = client.idClient
                      WHERE email = '$email' && langueId = '$lang'")->fetchAll();
    return $reservations;
  }

  // Fonction pour Annuler une réservation
  public function cancelResa($pdo, $email, $idReservation){
    $annulerReservation = $pdo->query("DELETE FROM reservation_chambre
                    WHERE idReservationChambre = '$idReservation'");
    return $annulerReservation;
  }

  // Fonction pour modifer réservation chambre
  public function updateResa($pdo, $idReservation){
    if (isset($_POST['updateResa'])) {
      $idChambre = $_POST['idChambre'];
      $CheckIn = $_POST['CheckIn'];
      $CheckOut = $_POST['CheckOut'];
      $req = $pdo->prepare("UPDATE reservation_chambre SET chambreId = :chambreId, dateArriver = :dateArriver, dateDepart = :dateDepart WHERE idReservationChambre = $idReservation");
      $req->bindParam(':chambreId', $idChambre, PDO::PARAM_INT);
      $req->bindParam(':dateArriver', $CheckIn, PDO::PARAM_INT);
      $req->bindParam(':dateDepart', $CheckOut, PDO::PARAM_INT);
      $req->execute();
      $updateResaSuccess = "La réservation à été modifier avec succès";
    }
    return @$updateResaSuccess;
  }
}

// Recherch client par email
function searchClientMail($pdo, $email){
  $checkMail = $pdo->query("SELECT * FROM client WHERE email = '$email'")->fetch();
  return $checkMail;
}

// insérer commentaire
function leaveComment($pdo, $cltId, $note, $title, $comment, $dateComment){
  $com = $pdo->prepare("INSERT INTO commentaire(clientId, note, titre, commentaire, dateComment) VALUES (?,?,?,?,?)");
  $com->bindParam(1, $cltId, PDO::PARAM_INT);
  $com->bindParam(2, $note, PDO::PARAM_INT);
  $com->bindParam(3, $title, PDO::PARAM_INT);
  $com->bindParam(4, $comment, PDO::PARAM_INT);
  $com->bindParam(5, $dateComment, PDO::PARAM_INT);
  $com->execute();
  return $com;
}

// Récupérer les commentaires poster par les clients
function getComments($pdo){
  $comments = $pdo->query("SELECT * FROM commentaire JOIN client ON client.idClient = commentaire.clientId");
  return $comments;
}


  function isValidTelephoneNumber(string $telephone, int $minDigits = 9, int $maxDigits = 14): bool {
    if (preg_match('/^[+][0-9]/', $telephone)) { //is the first character + followed by a digit
        $count = 1;
        $telephone = str_replace(['+'], '', $telephone, $count); //remove +
    }

    //remove white space, dots, hyphens and brackets
    $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone);

    //are we left with digits only?
    return isDigits($telephone, $minDigits, $maxDigits);
}

function normalizeTelephoneNumber(string $telephone): string {
    //remove white space, dots, hyphens and brackets
    $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone);
    return $telephone;
}


// Fonction pour l'espace de connexion front et back office
function verifyConnection($pdo, $table, $page, $lang){
  if(!empty($_POST)){
    // Une fois on rempli et envoyé la formulaire, $_POST contient les information saisie sous forme d'un tableau associatif
    // Le formulaire à été envoyé
    // On vérifie que tous les champs requis sont remplis

    if (isset($_POST["email"], $_POST["mdp"]) && !empty($_POST["email"]) && !empty($_POST["mdp"])) {
      // On vérifie que c'est un email
      if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errorConnection = "L'adresse mail est incorrecte";
      }
      $email = strip_tags($_POST['email']);
      $mdp =   strip_tags($_POST['mdp']);

      // On se connecte à la bdd
    //  $userExist = $db->query("SELECT * FROM users WHERE email =  '$email'")->fetch();

      $userExist = $pdo->prepare("SELECT * FROM $table WHERE email = :email");
      $userExist->bindValue(":email", $email, PDO::PARAM_STR);
      $userExist->execute();
      $user = $userExist->fetch();
      // Si l'utilisateur n'existe pas
      if (!$user) {
        $errorConnection = "L'utilisateur et/ou le mot de passe est incorrect";
      }

      else{
        if(!password_verify($mdp, $user['mdp']) || empty(trim($mdp))){

          $errorConnection = "L'utilisateur et/ou le mot de passe est incorrect";
        }
        else {

          // Ici l'utilisateur et le mot de passe sont corrects
          // On va pouvoir connecter l'utilisateur
          // On démarre la session
          session_start();
          // On stock dans $_SESSION les information de l'utilisateur
            $_SESSION["email"] = $email;
            $_SESSION["prenom"] = $user['prenom'];
           // var_dump($_SESSION);
          // On redirige vers la page de profile
          header("Location: $page?lang=$lang");
        }
      }

      // Ici on a un user existant, on vérifie son mote de passe
      // if(!password_verify($mdp, $userExist['pass'])){
      //   die ("Florian et Cindy sont passés par là");
       }

  }
  return @$errorConnection;
}

// Fonction pour modifier le mot de passe
function editPassword($pdo, $email, $table, $oldPassword, $newPassword, $repeatNewPassword){
  // On récupérer le mot de passe d'utilisateur courant
  $getPassword = $pdo->query("SELECT * FROM $table WHERE email = '$email'")->fetch();

  // On vérifie les données saisies par l'utilisateur
  if (password_verify($oldPassword, $getPassword['mdp'])  && !empty($oldPassword) && !empty($repeatNewPassword) && trim($newPassword) == trim($repeatNewPassword)) {
    // Si les données sont correctes, alors on prépare la réquête
    $editPassword = $pdo->prepare("UPDATE $table SET mdp = :mdp WHERE email = :email");
    $editPassword->bindParam(':mdp', password_hash($newPassword, PASSWORD_DEFAULT), PDO::PARAM_INT);
    $editPassword->bindParam(':email', $email, PDO::PARAM_INT);
    $editPassword->execute();
    // Et on affiche un message de succès de modification de mot de passe
    $sucessUpdateMessage = "Le mot de passe à été modifier avec succès";
  }
  else {
    // Sinon on affiche un message d'échec de modification de mot de passe
    $sucessUpdateMessage = "Erreur dans les valeurs entrées";
  }

  return $sucessUpdateMessage;
}
// Fonction pour récupérer les chambre
function getRooms($pdo, $lang, $where){
  $getRooms = $pdo->query("SELECT * FROM chambre
  LEFT JOIN categorie_chambre ON chambre.categorieChambreId = categorie_chambre.idCategorieChambre
  LEFT JOIN nom_categorie_chambre ON nom_categorie_chambre.categorieChambreId = categorie_chambre.idCategorieChambre
  && nom_categorie_chambre.langueId = '$lang'
  LEFT JOIN description_chambre ON chambre.categorieChambreId = description_chambre.categorieChambreId && description_chambre.langueId = '$lang'
  LEFT JOIN caracterestique_chambre ON categorie_chambre.idCategorieChambre = caracterestique_chambre.categorieChambreId && caracterestique_chambre.langueId = '$lang' WHERE $where GROUP BY chambre.categorieChambreId");
  return $getRooms;
}

// Récupérer les réservations restaurant
function getResaRestaurant($pdo, $email){
  $getResaRestaurant = $pdo->query("SELECT * FROM reservation_restaurant
                    JOIN client ON reservation_restaurant.clientId = client.idClient
                    WHERE email = '$email'");
  return $getResaRestaurant;
}
// Annuler reservation restaurant
function cancelResaRestaurant($pdo, $idReservationRestaurant){
  $annulerReservationRestaurant = $pdo->query("DELETE FROM reservation_restaurant WHERE  idReservationRestaurant = '$idReservationRestaurant'");
  return $annulerReservationRestaurant;
}
?>
