<?php
// Fonction pour savoir si l'utilisateur est connecté ou pas

// Fonction pour afficher les réservations dans l'espace client
function getClientResaBO($pdo){
  $reservations = $pdo->query("SELECT * FROM reservation_chambre
                    LEFT JOIN nom_categorie_chambre ON reservation_chambre.categorieChambreId = nom_categorie_chambre.categorieChambreId
                    LEFT JOIN client ON reservation_chambre.clientId = client.idClient WHERE langueId ='fr'");
  return $reservations;
}

// Annuler une réservation coté back office
function cancelResaBO($pdo, $idReservation){
  $annulerReservation = $pdo->query("DELETE FROM reservation_chambre
                  WHERE clientId IN(SELECT clientId FROM (SELECT * FROM reservation_chambre) AS reserv INNER JOIN client ON reservation_chambre.clientId = client.idClient
                  WHERE idReservationChambre = '$idReservation')");
  return $annulerReservation;
}

?>
