$(document).ready(function(){
    // On cache par défaut la section ainsi que la table
    //  des résultats tant que la requête AJAX n'a pas été
    //  accomplie.
    $("#room").hide();
    $("#room table").hide();

    function sendVerif(e) {
        e.preventDefault();
           $.post( "profile.php",
                   { CheckIn: $("#fromDate").val(),
                     CheckOut: $("#toDate").val(),
                     idCategorieChambre: $("#idCategorieChambre").val(),
                     idReservation: $("#idReservation").val(),
                     idChambre: $("#idChambre").val(),
                     verify: $("#verify").val()
                   },

                   function(data, status) {
                    // On transforme la chaîne de caractères
                    //   en objet JSON.
                     let json = JSON.parse(data);

                     // Dès l'arrivée d'un résultat, on affiche la section
                     //   mais pas la table des résultats.
                     $("#room").show();

                     if (json.price > 0)
                     {
                       // Si dans les données JSON, il est indiqué que le prix
                       //   n'est pas nulle, alors on cache le message indiquant
                       //   qu'aucune réservation n'est disponible et on afficher
                       //   la table des réservations disponibles.
                       $("#room table").show()
                       $("#room h3").hide()
                     }

                     // On contruit enfin le corps du tableau avec les données
                     //   de la réservation.
                     $("#tabBody").html(
                       `<tr>
                           <td>${json.dateArriver}</td>
                           <td>${json.dateDepart}</td>
                           <td>${json.price}</td>
                           <td>
                             <form class='' action='profile.php' method='post'>
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
