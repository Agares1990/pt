<?php
// Fonction pour savoir si l'utilisateur est connecté ou pas
function getConnectionText(){
  if(isset($_SESSION['email'])){
    $connection = "Deconnexion";
  }
  else{
    $connection = "Connexion";
  }
  return $connection;
}

// Fonction pour afficher les réservations dans l'espace client
function getClientResa($pdo, $email, $lang){
  $reservations = $pdo->query("SELECT * FROM reservation_chambre
                    LEFT JOIN nom_categorie_chambre ON reservation_chambre.categorieChambreId = nom_categorie_chambre.categorieChambreId
                    LEFT JOIN client ON reservation_chambre.clientId = client.idClient
                    WHERE email = '$email' && langueId = '$lang'");
  return $reservations;
}

// Fonction pour Annuler une réservation
function cancelResa($pdo, $email, $idReservation){
  $annulerReservation = $pdo->query("DELETE FROM reservation_chambre
                  WHERE clientId IN(SELECT clientId FROM (SELECT * FROM reservation_chambre) AS reserv INNER JOIN client ON reservation_chambre.clientId = client.idClient
                  WHERE email = '$email' && idReservationChambre = '$idReservation')");
  return $annulerReservation;
}



// Fonction pour modifer réservation chambre
function updateResa($pdo, $idReservation){
  if (isset($_POST['updateResa'])) {
    $idChambre = $_POST['idChambre'];
    $CheckIn = $_POST['CheckIn'];
    $CheckOut = $_POST['CheckOut'];
    $req = $pdo->prepare("UPDATE reservation_chambre SET chambreId = :chambreId, dateArriver = :dateArriver, dateDepart = :dateDepart WHERE idReservationChambre = $idReservation");
    $req->bindParam(':chambreId', $idChambre, PDO::PARAM_INT);
    $req->bindParam(':dateArriver', $CheckIn, PDO::PARAM_INT);
    $req->bindParam(':dateDepart', $CheckOut, PDO::PARAM_INT);
    $req->execute();

  }
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

// Génération des étoiles.
	// function GenerateStars(int $count)
	// {
	// 	$html = "";
  //
	// 	for ($indice = 1; $indice <= $count; $indice++)
	// 	{
	// 		$html .= "<img class='star' src='../images/star.png' alt='Étoile' width='16' height='16' />";
	// 	}
  //
	// 	return $html;
	// }

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



function verifyConnection($pdo, $table, $page){
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
           // var_dump($_SESSION);
          // On redirige vers la page de profile
          header("Location: $page");
        }
      }

      // Ici on a un user existant, on vérifie son mote de passe
      // if(!password_verify($mdp, $userExist['pass'])){
      //   die ("Florian et Cindy sont passés par là");
       }

  }
  return @$errorConnection;
}
?>
