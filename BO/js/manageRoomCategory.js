function verifyForm() {
  const tarifCategorieChambre = $("input[name='tarifCategorieChambre']").val()
  const image = $("input[name='image']").val()

    if ( isNaN(tarifCategorieChambre) || tarifCategorieChambre.trim().length == 0)
    {
      $("#ErrorJS").text("Le tarif de la catégorie de chambre est invalide ou laissé vide").css("color", "red");
      return false;
    }
    if ( image.trim().length == 0)
    {
      $("#ErrorJS").text("L'image de la chambre est invalide ou laissé vide").css("color", "red");
      return false;
    }
    else {
      return true;
    }
}

$("input[name='updateRoomCategory']").click(function(e)
{
  if (!verifyForm())
    event.preventDefault();
})
