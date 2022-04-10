
$(document).ready(function(){
  $( "input[name = 'search']" ).click( function(e)
  {
      e.preventDefault();

        $.post( "resaRoomBO.php",
          {
            CheckIn: $("#fromDate").val(),
            CheckOut: $("#toDate").val(),
            nbDay: $("input[name = 'nbDay']").val(),
            idCategorieChambre: $("#idCategorieChambre").val(),
            nbPerson: $("#nbPerson").val(),
            nbChild: $("#nbChild").val(),
            idChambre: $("#idChambre").val(),
            totalToPay: $("input[name = 'totalToPay']").val()
          },
        //  let data = JSON.stringify(data);
          function(data, status) {
            let data = JSON.stringify(data);
            let json = JSON.parse(data);
            //alert(json.idClient);
              console.log(json);
            $( "#reservation tbody" ).html(
               `<tr>
                   <td>${json.idClient}</td>
                   <td>${json.nom}</td>
                   <td>${json.prenom}</td>
                   <td>${json.email}</td>
                </tr>
                </table>
                 <form class='' action='resaRoomBO.php' method='post'>
                   <input type='hidden' name='idClient' value='${json.idClient}'>
                   <input type='hidden' name='CheckIn' value='${json.fromDate}'>
                   <input type='hidden' name='CheckOut' value='${json.toDate}'>
                   <input type='hidden' name='nbPerson' value='${json.nbPerson}'>
                   <input type='hidden' name='nbChild' value='${json.nbChild}'>
                   <input type='hidden' name='idCategorieChambre' value='${json.idCategorieChambre}'>
                   <input type='hidden' name='idRoom' value='${json.idRoom}'>
                   <input type='submit' id='resa' value='Valider la réservation'>
                 </form>`
            )
          }
        )
  } );
});
