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
function afficherReservationClient($pdo, $email, $lang){
  $reservations = $pdo->query("SELECT * FROM reservation_chambre
                    LEFT JOIN nom_categorie_chambre ON reservation_chambre.categorieChambreId = nom_categorie_chambre.categorieChambreId
                    LEFT JOIN client ON reservation_chambre.clientId = client.idClient
                    WHERE email = '$email' && langueId = '$lang'");
  return $reservations;
}

// Annuler une réservation
function annulerReservation($pdo, $email, $idReservation){
  $annulerReservation = $pdo->query("DELETE FROM reservation_chambre
                  WHERE clientId IN(SELECT clientId FROM (SELECT * FROM reservation_chambre) AS reserv INNER JOIN client ON reservation_chambre.clientId = client.idClient
                  WHERE email = '$email' && idReservationChambre = '$idReservation')");
  return $annulerReservation;
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
?>
