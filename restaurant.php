<?php
require "include/init_twig.php";
$css = "styleRestaurant";

echo $twig->render('restaurant.html.twig',
  	  array('css' => $css
  				));
?>
