<?php
require "include/init_twig.php";
$css = "styleEvent";

echo $twig->render('event.html.twig',
  	  array('css' => $css
  				));
?>
