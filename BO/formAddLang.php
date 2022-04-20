<?php
require_once ("include/_connexion.php");
require_once "../include/_functions.php";
session_start();

$pdo = getPDO();

  if (isset($_POST['addLang'])) {
    $idLang = $_POST['idLang'];
    $nameLang = $_POST['nameLang'];
    $iconLang = $_POST['iconLang'];

  if (preg_match("/^([a-zA-Z' ]+)$/",$idLang) && !empty(trim($idLang)) && preg_match("/^([a-zA-Z' ]+)$/",$nameLang) && !empty(trim($nameLang)) && !empty(trim($iconLang))) {
    $addLang = $pdo->prepare("INSERT INTO langue(idLangue, valeurLangue, iconeLangue) VALUES (?,?,?)");
    $addLang->bindParam(1, $idLang, PDO::PARAM_INT);
    $addLang->bindParam(2, $nameLang, PDO::PARAM_INT);
    $addLang->bindParam(3, $iconLang, PDO::PARAM_INT);
    $addLang->execute();
    $sucessAddLang = "La langue a été ajouté avec succès";
  }
  else {
    $sucessAddLang = "Erreur(s) dans le(s) valeur(s) entrée(s)";
  }

  }
  if (isset($sucessAddLang)) {
    header("Location: addLang.php?message=$sucessAddLang"); //Afficher le message de succès ou d'erreur si il y a un ou des erreurs lors d'envoie du formulaire
  }
?>
