let numero = 1;
const duree = 1000;
const nombreSlides = 5;

function chnageSlide() { // changer le slide automatiquement

  // On fait disparaitre le slide actuel
  $(".slide" + numero).fadeOut(duree, function()
  {
  // On fait apparaitre le slide suivant (numero + 1)
  numero = numero + 1;
  // Si le numéro est supérieur au nombre de slides alors le numéro est égal à 1
  if (numero > nombreSlides) {
      numero = 1;
  }
  $(".slide" + numero).fadeIn(duree);
});

}
setInterval(chnageSlide, 4000); // changer le slide chaque 4s



// function chnageSlide2() { // changer le slide automatiquement
//
//   // On fait disparaitre le slide actuel
//   $(".roomPhoto" + numero).fadeOut(duree, function()
//   {
//   // On fait apparaitre le slide suivant (numero + 1)
//   numero = numero + 1;
//   // Si le numéro est supérieur au nombre de slides alors le numéro est égal à 1
//   if (numero > nombreSlides) {
//       numero = 1;
//   }
//   $(".roomPhoto" + numero).fadeIn(duree);
// });
//
// }
// setInterval(chnageSlide2, 4000); // changer le slide chaque 4s
