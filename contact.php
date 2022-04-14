<?php
  require "include/init_twig.php";
  include_once("include/_traduction.php");
  include_once("include/_connexion.php");
  require_once "include/_functions.php";
  session_start();
  $css = "styleContact";
  $script = "contactForm";
  $pdo = getPDO();

  $connection = getConnectionText();

  function domain_exists($mail, $record = 'MX'){
        list($user, $domain) = explode('@', $mail);
        return checkdnsrr($domain, $record);
    }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {// S'execute uniquement lors d'une requete ajax
  $name = htmlspecialchars($_POST['name']);
  $mail = $_POST['mail'];
  $subject = htmlspecialchars($_POST['subject']);
  $message = htmlspecialchars($_POST['message']);


if (domain_exists($mail)) {
    $dateMessage = date('Y-m-d');
    $msg = $pdo->prepare("INSERT INTO message(nom, email, sujet, message, dateMessage) VALUES (?,?,?,?,?)");
    $msg->execute([$name, $mail, $subject, $message, $dateMessage]);
      echo "Passed";
  }
  else
      echo "Erreur adresse mail";
}


  echo $twig->render('contact.html.twig',
    	  array('css' => $css,
              'lang' => $lang,
              'name' => $traductions[$lang]["inputName"],
              'mail' => $traductions[$lang]["inputMail"],
              'subject' => $traductions[$lang]["inputSubject"],
              'submit' => $traductions[$lang]["inputSubmit"],
              'script' => $script,
              'connection' => $connection
    				));
?>
