<?php
  require "include/init_twig.php";
  include_once("include/_traduction.php");
  include_once("include/_connexion.php");
  require_once "include/_functions.php";
  session_start();
  $css = "styleContact";
  $script = "contactForm";
  $pdo = getPDO();
  $lang = getLang();
  @$email = $_SESSION['email'];
  $connection = getConnectionText($lang);

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
              'script' => $script,
              'connection' => $connection,
              'lang' => $lang,
              //Pour la traduction
              'nav1' => @$traductions[$lang]["nav1"],
              'nav2' => @$traductions[$lang]["nav2"],
              'nav3' => @$traductions[$lang]["nav3"],
              'nav4' => @$traductions[$lang]["nav4"],
              'nav5' => @$traductions[$lang]["nav5"],
              'profil' => @$traductions[$lang]["profil"],
              'connection' => $connection,
              'name' => $traductions[$lang]["inputName"],
              'mail' => $traductions[$lang]["inputMail"],
              'subject' => $traductions[$lang]["inputSubject"],
              'submit' => $traductions[$lang]["inputSubmit"],
              'Mentions' => @$traductions[$lang]["Mentions"],
              'politic' => @$traductions[$lang]["politic"],
              'condition' => @$traductions[$lang]["condition"],
              'adress' => @$traductions[$lang]["adress"]

    				));
?>
