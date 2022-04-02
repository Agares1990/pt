$( document ).ready( function ()
	{
		// Expression régulière des deux premiers champs (nom/sujet/message).
		const regex1 = /^[a-zA-Z ]{2,30}$/;

		// Expression régulière du dernier champ (email).
		const regex2 = /^(([^<>()\[\]\\.,;:\s@"]+( \.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1, 3}\.[0-9]{1, 3}\.[0-9]{1, 3}\.[0-9]{1, 3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

		// si le formulaire est correct, retourne 'true'
		// sinon affiche le message adéquat
		function checkForm()
		{
			// Vérification des champs formulaires
			const name = $( "input[name = 'name']" );
		  const mail = $( "input[name = 'mail']" );
		  const subject = $( "input[name = 'subject']" );
		  const message = $( "textarea[name = 'message']" );

			if ( !regex1.test( name.val() ))
			{
				$("#errorName").text("Votre nom est invalide ou laissé vide");
				return false;
			}
			if ( !regex2.test( mail.val() ))
			{
				$("#errorName").text("");
				$("#errorMail").text("Adresse mail invalide ou laissé vide");
				return false;
			}
			if ( !regex1.test( subject.val() ))
			{
				$("#errorMail").text("");
				$("#errorSubject").text("Votre sujet est invalide ou laissé vide");
				return false;
			}
			if ( !regex1.test( message.val() ))
			{
				$("#errorSubject").text("");
				$("#errorMessage").text("Veuillez écrire votre message");
				return false;
			}

			else {
				$("span").text("")
				$("#success").css("visibility", "visible");
				$("#successMessage").text("Le message a été envoyé avec succès !");
				return true;
			}

		}
		// réinitialise le formulaire
		function clearForm()
		{
			$( "textarea" ).val( "" );
			$( "input[type = \"text\"]" ).val( "" );
		}

		// si les données du formulaire sont correctes
		$( "input[type = \"submit\"]" ).click( function(e)
		{
	      e.preventDefault();
				if ( checkForm() )
				{
					// On envoie les données du formulaire via une
					//	requête de type POST.
					$.post( "contact.php",
						{
							// Nom
							name: $( "input[name = 'name']" ).val(),

							// Email
							mail: $( "input[name = 'mail']" ).val(),

							// Adresse email
							subject: $( "input[name = 'subject']" ).val(),

							// Message
							message: $( "textarea[name = 'message']" ).val()
						// }, function(staut, data) {
						// 	console.log(staut, data);
						});

					// On supprime les données du formulaire seulement
					//	si toutes les données ont été validées.
					clearForm();
				}
		} );
		// cacher le message du succès lorsqu'on clique sur X (#closebtn)
		$("#closebtn").click(function cacherMessage()
		{
  		$("#success").hide();
		});
	});
