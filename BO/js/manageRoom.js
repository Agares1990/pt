$(document).ready(function(){
  $("#btnAddRoom+form").hide()
  $("#btnAddRoom").click(function() {
    $("#btnAddRoom+form").show();
  });
  function verifyForm() {
    const numRoom = $("input[name='numRoom']").val()
    const idRoomType = $("input[name='idRoomType']").val()
    const image = $("input[name='image']").val()
    const nbPerson = $("input[name='nbPerson']").val()
    const nbChild = $("input[name='nbChild']").val()

      if ( isNaN(numRoom) || numRoom.trim().length == 0)
      {
        $("#ErrorJS").text("Le numéro de la chambre est invalide ou laissé vide").css("color", "red");
        return false;
      }
      if (idRoomType.trim().length == 0)
      {
        $("#ErrorJS").text("La Catégorie de la chambre est invalide ou laissé vide").css("color", "red");
        return false;
      }
      if ( image.trim().length == 0)
      {
        $("#ErrorJS").text("L'image de la chambre est invalide ou laissé vide").css("color", "red");
        return false;
      }
      if ( isNaN( nbPerson ) || nbPerson.trim().length == 0)
      {
        $("#ErrorJS").text("La capacité d'adulte de la chambre est invalide ou laissé vide").css("color", "red");
        return false;
      }
      if ( isNaN( nbChild ) || nbChild.trim().length == 0)
      {
        $("#ErrorJS").text("La capacité d'enfant de la chambre est invalide ou laissé vide").css("color", "red");
        return false;
      }
      else {
        return true;
      }
  }

  $("input[name='addRoom']").click(function(e)
  {
    if (!verifyForm())
      event.preventDefault();
  })

  // Vérification formulaire de modification de chambre

  function verifyUpdateForm() {
    const idRoomType = $("#idRoomType").val()
    const image = $("#image").val()
    const nbPerson = $("#nbPerson").val()
    const nbChild = $("#nbChild").val()

      if ( isNaN( idRoomType ) || idRoomType.trim().length == 0)
      {
        $("#ErrorJS").text("La Catégorie de la chambre est invalide ou laissé vide").css("color", "red");
        return false;
      }
      if ( image.trim().length == 0)
      {
        $("#ErrorJS").text("L'image de la chambre est invalide ou laissé vide").css("color", "red");
        return false;
      }
      if ( isNaN( nbPerson ) || nbPerson.trim().length == 0)
      {
        $("#ErrorJS").text("La capacité d'adulte de la chambre est invalide ou laissé vide").css("color", "red");
        return false;
      }
      if ( isNaN( nbChild ) || nbChild.trim().length == 0)
      {
        $("#ErrorJS").text("La capacité d'enfant de la chambre est invalide ou laissé vide").css("color", "red");
        return false;
      }
      else {
        return true;
      }
  }
  $("input[name='updateRoom']").click(function(e)
  {
    if (!verifyUpdateForm())
      event.preventDefault();
  })
});
