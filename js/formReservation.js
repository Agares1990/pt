$( "input[name= 'submit']" ).click( function()
{
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

  });
