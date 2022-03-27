<?php
require "include/init_twig.php";
require "include/_connexion.php";
include("include/_traduction.php");
$css = "styleFormReservation";

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
}
echo $twig->render('formReservation.html.twig',
  	  array('css' => $css,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'nbPerson' => $nbPerson,
            'nbChild' => $nbChild,
            'roomType' => $roomType,
            'idRoom' => $idRoom,
            'idCategorieChambre' => $idCategorieChambre,
            'nbDay' => $nbDay,
            'totalToPay' => $totalToPay
  				));
?>
