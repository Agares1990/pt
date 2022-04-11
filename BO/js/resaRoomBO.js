$(document).ready(function(){
  function verifyForm() {
    //Vérification de formulaire de réservation générer par ajax
    // Expression régulière des champs (nom/prenom/message/payes).
      const regex1 = /^[a-zA-Z ]{2,30}$/;
      const regex3 = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

      // Expression régulière du dernier champ (email).
      const regex2 = /^(([^<>()\[\]\\.,;:\s@"]+( \.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1, 3}\.[0-9]{1, 3}\.[0-9]{1, 3}\.[0-9]{1, 3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

      // si le formulaire est correct, retourne 'true'
      // sinon affiche le message adéquat
        // Vérification des champs formulaires
        const nom = $( "input[name = 'nom']" ).val();
        const prenom = $( "input[name = 'prenom']" ).val();
        const email = $( "input[name = 'email']" ).val();
        const mdp = $( "input[name = 'mdp']" ).val();
        const tel = $( "input[name = 'tel']" ).val();
        const pays = $( "select[name = 'pays']" ).val();
        const message = $( "textarea[name = 'message']" ).val();
        $( "#formReservation" ).prop( "disabled", true );
        if ( !regex1.test( nom ) || nom.trim().length == 0)
        {
          $("#errorNom").text("Votre nom est invalide ou laissé vide");
          return false;
        }
        if ( !regex1.test( prenom ) || prenom.trim().length == 0)
        {
          $("input+span").text("");
          $("#errorPrenom").text("Votre prenom est invalide ou laissé vide");
          return false;
        }
        if ( !regex2.test( email))
        {
          $("input+span").text("");
          $("#errorMail").text("Adresse mail invalide ou laissé vide");
          return false;
        }

        if ( mdp.trim().length == 0)
        {
          $("input+span").text("");
          $("#errorPass").text("Veuillez entrer un mot de passe svp");
          return false;
        }

        if ( !regex3.test( tel ) || tel.trim().length == 0)
        {
          $("input+span").text("");
          $("#errorTel").text("Veuillez saisir un numéro de téléphone valide svp");
          return false;
        }
        if (pays.trim().length == 0)
        {
          $("input+span").text("");
          $("#errorPays").text("Veuillez choisir votre pays svp");
          return false;
        }
        else {
          return true;
        }
  }

  console.log(verifyForm)
  $( "#recherch input[type = 'submit']" ).click( function(event)
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
            console.log(verifyForm)
            //console.log(json);
            if(json.email != null){ // Si il trouve l'email == le client existe
              //Alors on construit un tableau avec un formulaire pour valider la réservation
              $( "#reservation" ).html(
                 `<p id="success">Client trouvé</p>
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
                     <input type='submit' name='valideClientResa' id='resa' value='Valider la réservation'>
                   </form>`
              )
              }
              else { // si il trouve pas l'email, alors on affiche le formulaire de réservation
                console.log(verifyForm)
                $( "#reservation" ).html(
                  `<p>Nous n'avons pas trouvé cet email</p>
                   <p>Veuillez remplir le formulaire de réservation</p>
                  <form id="formReservation" action="recapReservationBO.php" method="post">
                       <input type="hidden" id="CheckIn" name="CheckIn" value='${json.fromDate}'>
                       <input type="hidden" id="CheckOut" name="CheckOut" value='${json.toDate}'>
                       <input type="hidden" id="nbDay" name="nbDay" value='${json.nbDay}'>
                       <input type='hidden' name='idCategorieChambre' value='${json.idCategorieChambre}'>
                       <input type='hidden' name='nbPerson' value='${json.nbPerson}'>
                       <input type='hidden' name='nbChild' value='${json.nbChild}'>
                       <input type='hidden' name='idChambre' value='${json.idRoom}'>
                       <input type="hidden" id="roomType" name="roomType" value='${json.roomType}'>
                       <input type="hidden" id="totalToPay" name="totalToPay" value='${json.totalToPay}'>

                       <input type="text" name="nom" placeholder="Votre nom:" >
                       <span id="errorNom"></span>

                       <input type="text" name="prenom" placeholder="Votre prénom:">
                       <span id="errorPrenom"></span>

                       <input type="text" name="email" placeholder="Votre email" maxlength="100" >
                       <span id="errorMail"></span>

                       <input type="password" name="mdp" placeholder="Votre mot de passe:">
                       <span id="errorPass"></span>

                       <input type="tel" name="tel" placeholder="Votre numéro de téléphone">
                       <span id="errorTel"></span>

                       <select name="pays">
                          <option value="France" selected="selected">France </option>
                          <option value="Afghanistan">Afghanistan </option>
                          <option value="Afrique_Centrale">Afrique_Centrale </option>
                          <option value="Afrique_du_sud">Afrique_du_Sud </option>
                          <option value="Albanie">Albanie </option>
                          <option value="Algerie">Algerie </option>
                          <option value="Allemagne">Allemagne </option>
                          <option value="Andorre">Andorre </option>
                          <option value="Angola">Angola </option>
                          <option value="Anguilla">Anguilla </option>
                          <option value="Arabie_Saoudite">Arabie_Saoudite </option>
                          <option value="Argentine">Argentine </option>
                          <option value="Armenie">Armenie </option>
                          <option value="Australie">Australie </option>
                          <option value="Autriche">Autriche </option>
                          <option value="Azerbaidjan">Azerbaidjan </option>
                          <option value="Bahamas">Bahamas </option>
                          <option value="Bangladesh">Bangladesh </option>
                          <option value="Barbade">Barbade </option>
                          <option value="Bahrein">Bahrein </option>
                          <option value="Belgique">Belgique </option>
                          <option value="Belize">Belize </option>
                          <option value="Benin">Benin </option>
                          <option value="Bermudes">Bermudes </option>
                          <option value="Bielorussie">Bielorussie </option>
                          <option value="Bolivie">Bolivie </option>
                          <option value="Botswana">Botswana </option>
                          <option value="Bhoutan">Bhoutan </option>
                          <option value="Boznie_Herzegovine">Boznie_Herzegovine </option>
                          <option value="Bresil">Bresil </option>
                          <option value="Brunei">Brunei </option>
                          <option value="Bulgarie">Bulgarie </option>
                          <option value="Burkina_Faso">Burkina_Faso </option>
                          <option value="Burundi">Burundi </option>
                          <option value="Caiman">Caiman </option>
                          <option value="Cambodge">Cambodge </option>
                          <option value="Cameroun">Cameroun </option>
                          <option value="Canada">Canada </option>
                          <option value="Canaries">Canaries </option>
                          <option value="Cap_vert">Cap_Vert </option>
                          <option value="Chili">Chili </option>
                          <option value="Chine">Chine </option>
                          <option value="Chypre">Chypre </option>
                          <option value="Colombie">Colombie </option>
                          <option value="Comores">Colombie </option>
                          <option value="Congo">Congo </option>
                          <option value="Congo_democratique">Congo_democratique </option>
                          <option value="Cook">Cook </option>
                          <option value="Coree_du_Nord">Coree_du_Nord </option>
                          <option value="Coree_du_Sud">Coree_du_Sud </option>
                          <option value="Costa_Rica">Costa_Rica </option>
                          <option value="Cote_d_Ivoire">Côte_d_Ivoire </option>
                          <option value="Croatie">Croatie </option>
                          <option value="Cuba">Cuba </option>
                          <option value="Danemark">Danemark </option>
                          <option value="Djibouti">Djibouti </option>
                          <option value="Dominique">Dominique </option>
                          <option value="Egypte">Egypte </option>
                          <option value="Emirats_Arabes_Unis">Emirats_Arabes_Unis </option>
                          <option value="Equateur">Equateur </option>
                          <option value="Erythree">Erythree </option>
                          <option value="Espagne">Espagne </option>
                          <option value="Estonie">Estonie </option>
                          <option value="Etats_Unis">Etats_Unis </option>
                          <option value="Ethiopie">Ethiopie </option>
                          <option value="Falkland">Falkland </option>
                          <option value="Feroe">Feroe </option>
                          <option value="Fidji">Fidji </option>
                          <option value="Finlande">Finlande </option>
                          <option value="France">France </option>
                          <option value="Gabon">Gabon </option>
                          <option value="Gambie">Gambie </option>
                          <option value="Georgie">Georgie </option>
                          <option value="Ghana">Ghana </option>
                          <option value="Gibraltar">Gibraltar </option>
                          <option value="Grece">Grece </option>
                          <option value="Grenade">Grenade </option>
                          <option value="Groenland">Groenland </option>
                          <option value="Guadeloupe">Guadeloupe </option>
                          <option value="Guam">Guam </option>
                          <option value="Guatemala">Guatemala</option>
                          <option value="Guernesey">Guernesey </option>
                          <option value="Guinee">Guinee </option>
                          <option value="Guinee_Bissau">Guinee_Bissau </option>
                          <option value="Guinee equatoriale">Guinee_Equatoriale </option>
                          <option value="Guyana">Guyana </option>
                          <option value="Guyane_Francaise ">Guyane_Francaise </option>
                          <option value="Haiti">Haiti </option>
                          <option value="Hawaii">Hawaii </option>
                          <option value="Honduras">Honduras </option>
                          <option value="Hong_Kong">Hong_Kong </option>
                          <option value="Hongrie">Hongrie </option>
                          <option value="Inde">Inde </option>
                          <option value="Indonesie">Indonesie </option>
                          <option value="Iran">Iran </option>
                          <option value="Iraq">Iraq </option>
                          <option value="Irlande">Irlande </option>
                          <option value="Islande">Islande </option>
                          <option value="Israel">Israel </option>
                          <option value="Italie">italie </option>
                          <option value="Jamaique">Jamaique </option>
                          <option value="Jan Mayen">Jan Mayen </option>
                          <option value="Japon">Japon </option>
                          <option value="Jersey">Jersey </option>
                          <option value="Jordanie">Jordanie </option>
                          <option value="Kazakhstan">Kazakhstan </option>
                          <option value="Kenya">Kenya </option>
                          <option value="Kirghizstan">Kirghizistan </option>
                          <option value="Kiribati">Kiribati </option>
                          <option value="Koweit">Koweit </option>
                          <option value="Laos">Laos </option>
                          <option value="Lesotho">Lesotho </option>
                          <option value="Lettonie">Lettonie </option>
                          <option value="Liban">Liban </option>
                          <option value="Liberia">Liberia </option>
                          <option value="Liechtenstein">Liechtenstein </option>
                          <option value="Lituanie">Lituanie </option>
                          <option value="Luxembourg">Luxembourg </option>
                          <option value="Lybie">Lybie </option>
                          <option value="Macao">Macao </option>
                          <option value="Macedoine">Macedoine </option>
                          <option value="Madagascar">Madagascar </option>
                          <option value="Madère">Madère </option>
                          <option value="Malaisie">Malaisie </option>
                          <option value="Malawi">Malawi </option>
                          <option value="Maldives">Maldives </option>
                          <option value="Mali">Mali </option>
                          <option value="Malte">Malte </option>
                          <option value="Man">Man </option>
                          <option value="Mariannes du Nord">Mariannes du Nord </option>
                          <option value="Maroc">Maroc </option>
                          <option value="Marshall">Marshall </option>
                          <option value="Martinique">Martinique </option>
                          <option value="Maurice">Maurice </option>
                          <option value="Mauritanie">Mauritanie </option>
                          <option value="Mayotte">Mayotte </option>
                          <option value="Mexique">Mexique </option>
                          <option value="Micronesie">Micronesie </option>
                          <option value="Midway">Midway </option>
                          <option value="Moldavie">Moldavie </option>
                          <option value="Monaco">Monaco </option>
                          <option value="Mongolie">Mongolie </option>
                          <option value="Montserrat">Montserrat </option>
                          <option value="Mozambique">Mozambique </option>
                          <option value="Namibie">Namibie </option>
                          <option value="Nauru">Nauru </option>
                          <option value="Nepal">Nepal </option>
                          <option value="Nicaragua">Nicaragua </option>
                          <option value="Niger">Niger </option>
                          <option value="Nigeria">Nigeria </option>
                          <option value="Niue">Niue </option>
                          <option value="Norfolk">Norfolk </option>
                          <option value="Norvege">Norvege </option>
                          <option value="Nouvelle_Caledonie">Nouvelle_Caledonie </option>
                          <option value="Nouvelle_Zelande">Nouvelle_Zelande </option>
                          <option value="Oman">Oman </option>
                          <option value="Ouganda">Ouganda </option>
                          <option value="Ouzbekistan">Ouzbekistan </option>
                          <option value="Pakistan">Pakistan </option>
                          <option value="Palau">Palau </option>
                          <option value="Palestine">Palestine </option>
                          <option value="Panama">Panama </option>
                          <option value="Papouasie_Nouvelle_Guinee">Papouasie_Nouvelle_Guinee </option>
                          <option value="Paraguay">Paraguay </option>
                          <option value="Pays_Bas">Pays_Bas </option>
                          <option value="Perou">Perou </option>
                          <option value="Philippines">Philippines </option>
                          <option value="Pologne">Pologne </option>
                          <option value="Polynesie">Polynesie </option>
                          <option value="Porto_Rico">Porto_Rico </option>
                          <option value="Portugal">Portugal </option>
                          <option value="Qatar">Qatar </option>
                          <option value="Republique_Dominicaine">Republique_Dominicaine </option>
                          <option value="Republique_Tcheque">Republique_Tcheque </option>
                          <option value="Reunion">Reunion </option>
                          <option value="Roumanie">Roumanie </option>
                          <option value="Royaume_Uni">Royaume_Uni </option>
                          <option value="Russie">Russie </option>
                          <option value="Rwanda">Rwanda </option>
                          <option value="Sahara Occidental">Sahara Occidental </option>
                          <option value="Sainte_Lucie">Sainte_Lucie </option>
                          <option value="Saint_Marin">Saint_Marin </option>
                          <option value="Salomon">Salomon </option>
                          <option value="Salvador">Salvador </option>
                          <option value="Samoa_Occidentales">Samoa_Occidentales</option>
                          <option value="Samoa_Americaine">Samoa_Americaine </option>
                          <option value="Sao_Tome_et_Principe">Sao_Tome_et_Principe </option>
                          <option value="Senegal">Senegal </option>
                          <option value="Seychelles">Seychelles </option>
                          <option value="Sierra Leone">Sierra Leone </option>
                          <option value="Singapour">Singapour </option>
                          <option value="Slovaquie">Slovaquie </option>
                          <option value="Slovenie">Slovenie</option>
                          <option value="Somalie">Somalie </option>
                          <option value="Soudan">Soudan </option>
                          <option value="Sri_Lanka">Sri_Lanka </option>
                          <option value="Suede">Suede </option>
                          <option value="Suisse">Suisse </option>
                          <option value="Surinam">Surinam </option>
                          <option value="Swaziland">Swaziland </option>
                          <option value="Syrie">Syrie </option>
                          <option value="Tadjikistan">Tadjikistan </option>
                          <option value="Taiwan">Taiwan </option>
                          <option value="Tonga">Tonga </option>
                          <option value="Tanzanie">Tanzanie </option>
                          <option value="Tchad">Tchad </option>
                          <option value="Thailande">Thailande </option>
                          <option value="Tibet">Tibet </option>
                          <option value="Timor_Oriental">Timor_Oriental </option>
                          <option value="Togo">Togo </option>
                          <option value="Trinite_et_Tobago">Trinite_et_Tobago </option>
                          <option value="Tristan da cunha">Tristan de cuncha </option>
                          <option value="Tunisie">Tunisie </option>
                          <option value="Turkmenistan">Turmenistan </option>
                          <option value="Turquie">Turquie </option>
                          <option value="Ukraine">Ukraine </option>
                          <option value="Uruguay">Uruguay </option>
                          <option value="Vanuatu">Vanuatu </option>
                          <option value="Vatican">Vatican </option>
                          <option value="Venezuela">Venezuela </option>
                          <option value="Vierges_Americaines">Vierges_Americaines </option>
                          <option value="Vierges_Britanniques">Vierges_Britanniques </option>
                          <option value="Vietnam">Vietnam </option>
                          <option value="Wake">Wake </option>
                          <option value="Wallis et Futuma">Wallis et Futuma </option>
                          <option value="Yemen">Yemen </option>
                          <option value="Yougoslavie">Yougoslavie </option>
                          <option value="Zambie">Zambie </option>
                          <option value="Zimbabwe">Zimbabwe </option>
                       </select>
                       <span id="errorPays"></span>

                        <textarea name="message" id="message" placeholder="Requête spéciale" rows="8" cols="40"></textarea>
                        <span id="errorMessage"></span>

                      <input id="formResa" type="submit" name="reserver" value="Réserver">

                  </form>
                  `
                )

                $("#formReservation").submit(function(event)
                {
                    if (!verifyForm())
                      event.preventDefault();
                })
              }
          }
        )
  } );


});
