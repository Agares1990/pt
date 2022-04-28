$(document).ready(function(){
  $( "#submit" ).click( function()
{
// Expression régulière les champs de dates.
  const regex1 = /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;

  // si le formulaire est correct, retourne 'true'
  // sinon affiche le message adéquat
    // Vérification des champs formulaires
    const fromDate = $( "#fromDate" ).val();
    const toDate = $( "#toDate" ).val();
    const nbPerson = $( "#nbPerson" ).val();
    const nbChild = $( "#nbChild" ).val();

    //$( "#formReservation" ).prop( "disabled", true );
    if ( !regex1.test( fromDate ) || fromDate.trim().length == 0)
    {
      $("#erreur").text("Veuillez entrer une date d'arrivé valide (année-mois-jour)");
      return false;
    }
    if ( !regex1.test( toDate ) || toDate.trim().length == 0)
    {
      $("#erreur").text("Veuillez entrer une date de départ valide (année-mois-jour)");
      return false;
    }
    if ($("#nbPerson option:selected").index() == 0)
    {
      $("#erreur").text("Veuillez choisir le nombre d'adulte svp");
      return false;
    }

    if ($("#nbChild option:selected").index() == 0)
    {
      $("#erreur").text("Veuillez choisir le nombre d'enfant svp");
      return false;
    }

    });
  });
