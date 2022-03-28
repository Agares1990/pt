// réinitialise le formulaire
	// (c.a.d. positionne l'attibut
	// 'value' de tous les champs à "")
	function clearForm()
	{
		$( "textarea" ).val( "" );
		$( "input[type = \"text\"]" ).val( "" );
	}
	// si les données du formulaire sont correctes
	// elles sont transmises au script savecontact.php via
	// un requête AJAX. Le script retourne 'OK' si l'email
	// est correct (et dans ce cas, le message est enregistré)
	// ou bien 'KO' sinon (et dans ce cas, le message n'est pas
	// enregistré)
	$( "input[type = \"submit\"]" ).click( function ()
	{
     e.preventDefault();
			// On envoie les données du formulaire via une
			//	requête de type POST.
			$.post( "../contact.php",
				{
					// Nom
					name: $( "input[name = 'name']" ).val(),

					// Email
					mail: $( "input[name = 'mail']" ).val(),

					// Adresse email
					subject: $( "input[name = 'subject']" ).val(),

					// Message
					message: $( "textarea[name = 'message']" ).val()
				} );

			// On supprime les données du formulaire seulement
			//	si toutes les données ont été validées.
			clearForm();

	} );
