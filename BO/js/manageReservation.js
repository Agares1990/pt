$(document).ready(function(){

// TABLEAU MODIFICATION RESERVATION CHAMBRE
  // On cache par défaut la section ainsi que la table
  //  des résultats tant que la requête AJAX n'a pas été
  //  accomplie.
  $("#room").hide();
  $("#room table").hide();


  function sendVerif(e) {
    const checkIn = $( "input[name = 'CheckIn']" ).val();
    const checkOut = $( "input[name = 'CheckOut']" ).val();
      e.preventDefault();
         $.post( "manageReservation.php",
                 { CheckIn: checkIn,
                   CheckOut: checkOut,
                   idCategorieChambre: $("#idCategorieChambre").val(),
                   idReservation: $("#idReservation").val(),
                   idChambre: $("#idChambre").val(),
                   verify: $("#verify").val()
                 },

                 function(data, status) {
                  // On transforme la chaîne de caractères
                  //   en objet JSON.
                   let json = JSON.parse(data);



                   // Si la date d'arrivée et/ou date de départ n'est pas remplis
                   // alors on affiche une message d'erreur
                   if ( checkIn.trim().length == 0 || checkOut.trim().length == 0)
                   {
                     $("#checkIn h3").text("Veuillez entrez la date d'arrivée et la date de départ svp");
                   }

                   if (json.price < 0)
                   {
                     $("#room table").hide()
                     $("#checkIn h3").text("Désolé, nous n'avons pas de disponibilité pendant ces dates")

                   }
                   else if (json.price > 0){
                     // Si dans les données JSON, il est indiqué que le prix
                     //   n'est pas nulle, alors on cache le message indiquant
                     //   qu'aucune réservation n'est disponible et on afficher
                     //   la table des réservations disponibles.
                     //$("#room").show();
                     $("#checkIn h3").hide()
                     $("#room").show()
                     $("#room table").show()

                   }

                   // On contruit enfin le corps du tableau avec les données
                   //   de la réservation.
                   $("#tabBody").html(
                     `<tr>
                         <td>${json.dateArriver}</td>
                         <td>${json.dateDepart}</td>
                         <td>${json.price}</td>
                         <td>
                           <form class='' action='manageReservation.php' method='post'>
                             <input type='hidden' name='CheckIn' value='${json.dateArriver}'>
                             <input type='hidden' name='CheckOut' value='${json.dateDepart}'>
                             <input type='hidden' name='idReservation' value='${json.idReservation}'>
                             <input type='hidden' name='idChambre' value='${json.idChambre}'>
                             <input type='hidden' name='updateResa' value='1'>
                             <input type='submit' id='update' value='Valider la modification'>
                           </form>
                         </td>
                     </tr>`)

        });

  };
  $('#verifier').click(sendVerif);
});
