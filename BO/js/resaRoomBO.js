
$(document).ready(function(){
  $( "input[type = 'submit']" ).click( function(event)
  {
      event.preventDefault();

        $.post( "resaRoomBO.php",
          {
            CheckIn: $("#CheckIn").val(),
            CheckOut: $("#CheckOut").val(),
            nbDay: $("input[name = 'nbDay']").val(),
            idCategorieChambre: $("#idCategorieChambre").val(),
            nbPerson: $("#nbPerson").val(),
            nbChild: $("#nbChild").val(),
            roomType: $("#roomType").val(),
            idChambre: $("#idChambre").val(),
            totalToPay: $("input[name = 'totalToPay']").val(),
            recherche: $("input[name = recherche]").val(), // Adresse email saisi
            search: "" // Signifie qu'on soumet le formulaire.
          },

          function(data, status) {
            let json = JSON.parse(data);
            console.log(json);
            if(json.email != null){ // Si il trouve l'email == le client existe
              //Alors on construit un tableau avec un formulaire pour valider la réservation
              $( "#reservation" ).html(
                 `<p>Client trouvé</p>
                 <table>
                   <thead>
                     <tr>
                         <th>Identifiant Client</th>
                         <th>Nom</th>
                         <th>Prénom</th>
                         <th>Email</th>
                      </tr>
                   </thead>
                   <tbody>
                     <tr>
                         <td>${json.idClient}</td>
                         <td>${json.nom}</td>
                         <td>${json.prenom}</td>
                         <td>${json.email}</td>
                      </tr>
                  </tbody>
                  </table>
                   <form class='' action='resaRoomBO.php' method='post'>
                     <input type='hidden' name='idClient' value='${json.idClient}'>
                     <input type='hidden' name='CheckIn' value='${json.fromDate}'>
                     <input type='hidden' name='CheckOut' value='${json.toDate}'>
                     <input type="hidden" id="nbDay" name="nbDay" value='${json.nbDay}'>
                     <input type='hidden' name='nbPerson' value='${json.nbPerson}'>
                     <input type='hidden' name='nbChild' value='${json.nbChild}'>
                     <input type='hidden' name='idCategorieChambre' value='${json.idCategorieChambre}'>
                     <input type='hidden' name='idRoom' value='${json.idRoom}'>
                     <input type='submit' id='resa' value='Valider la réservation'>
                   </form>`
              )
              }
              else { // si il trouve pas l'email, alors on affiche le formulaire de réservation
                $( "#reservation" ).html(
                  `<p>Nous n'avons pas trouvé cet email</p>
                  <form id="formReservation" action="recapReservationBO.php" method="post">
                       <input type="hidden" id="CheckIn" name="CheckIn" value='${json.fromDate}'>
                       <input type="hidden" id="CheckOut" name="CheckOut" value='${json.toDate}'>
                       <input type="hidden" id="nbDay" name="nbDay" value='${json.nbDay}'>
                       <input type='hidden' name='idCategorieChambre' value='${json.idCategorieChambre}'>
                       <input type='hidden' name='nbPerson' value='${json.nbPerson}'>
                       <input type='hidden' name='nbChild' value='${json.nbChild}'>
                       <input type='hidden' name='idRoom' value='${json.idRoom}'>
                       <input type="hidden" id="roomType" name="roomType" value='${json.roomType}'>
                       <input type="hidden" id="totalToPay" name="totalToPay" value='${json.totalToPay}'>

                       <input type="text" name="nom" id="nom" placeholder="Votre nom:">
                       <span id="errorNom"></span>

                       <input type="text" name="prenom" id="prenom" placeholder="Votre prénom:">
                       <span id="errorPrenom"></span>

                       <input type="text" name="email" id="email" placeholder="Votre email" maxlength="100" >
                       <span id="errorMail"></span>

                       <input type="password" name="mdp" id="mdp" placeholder="Votre mot de passe:">
                       <span id="errorPass"></span>

                       <input type="tel" name="tel" id="tel" placeholder="Votre numéro de téléphone">
                       <span id="errorTel"></span>

                       <input type="text" name="pays" id="pays" placeholder="Votre pays:">

                       <span id="errorPays"></span>

                        <textarea name="message" id="message" placeholder="Requête spéciale" rows="8" cols="40"></textarea>
                        <span id="errorMessage"></span>

                      <input id="submit" type="submit" name="submit" class="button" value="Réserver">

                  </form>
                  `
                )
              }
          }
        )
  } );
});
