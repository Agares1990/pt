<?php

include_once("include/_traduction.php");
include_once("include/_connexion.php");
require_once "include/_functions.php";

$pdo = getPDO();
$lang = getLang();


if (isset($_POST['deleteUser'])) {
  $idClient = $_POST['idClient'];

  $deletUser = deletUser($pdo, $idClient);
  $successDelet = "Votre compte a été supprimé avec succès";

  header("Location: connexion.php?lang=$lang&successDelet=$successDelet");
  die();
}
session_start();
session_unset();
session_destroy();
session_start();
?>
