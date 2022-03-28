<?php
  require "include/init_twig.php";
  include_once("include/_traduction.php");
  include_once("include/_connexion.php");
  $css = "styleContact";
  $script = "contactForm";
  $pdo = getPDO();

  function domain_exists($mail, $record = 'MX'){
        list($user, $domain) = explode('@', $mail);
        return checkdnsrr($domain, $record);
    }
if (isset($_POST['send'])) {
  $name = $_POST['name'];
  $mail = $_POST['mail'];
  $subject = $_POST['subject'];
  $message = htmlspecialchars($_POST['message']);

  if (domain_exists($mail)) {
    $stmt = $pdo->prepare("INSERT INTO `message`(`nom`,`email`,`sujet`,`message`) VALUES (?,?,?,?)");
    $stmt->execute([$name,$mail,$subject,$message]);
      echo "Passed";
      var_dump($stmt);
  }
  else
      echo "Failed";
}


  echo $twig->render('contact.html.twig',
    	  array('css' => $css,
              'lang' => $lang,
              'name' => $traductions[$lang]["inputName"],
              'mail' => $traductions[$lang]["inputMail"],
              'subject' => $traductions[$lang]["inputSubject"],
              'submit' => $traductions[$lang]["inputSubmit"],
              'script' => $script
    				));
?>
