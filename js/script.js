let formCheck = document.querySelector("#formChek");
let clicked = false;
function cacherFormCheck() {
  if (formCheck.style.display == "none") {
    formCheck.style.display = "block";
    clicked = true;
  }
  else {
    formCheck.style.display = "none";
    clicked = false;
  }

}

window.addEventListener("scroll", () => {
    if (clicked)
      return;
    if (window.scrollY > 200) { // Si on scroll plus de 200px
      formCheck.style.display = "none";
    }
    else {
      formCheck.style.display = "block";
    }
});

// Date picker
$( function() {
    let from = $( "#fromDate" )
      .datepicker({
        defaultDate: "+1w",
        showAnim: 'drop',
        minDate : new Date(), // Ne pas autoriser la sélection d'une date antérieur de la date d'aujourd'hui
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        to.datepicker( "option", "minDate", getDate( this ) );
      }),
    to = $( "#toDate" ).datepicker({
      defaultDate: "+1w",
      showAnim: 'drop',
      dateFormat: "yy-mm-dd",
      changeMonth: true,
      numberOfMonths: 1
    })
    .on( "change", function() {
      from.datepicker( "option", "maxDate", getDate( this ) );
    });

  function getDate( element ) {
    var date;
    let dateFormat= "yy-mm-dd";
    try {
      date = $.datepicker.parseDate( dateFormat, element.value );
    } catch( error ) {
      date = null;
    }
    return date;
  }
} );

let num = 1;
const duration = 1000;
const nombreMenu = 5;

// Si on clique sur la flèche "toggleRight"
$("#toggleRight").click(function () {

    // On fait disparaitre le item actuel

    // On fait apparaitre le item toggleRight (num + 1)
    num = num + 1;
    // Si le numéro est supérieur au nombre de items alors le numéro est égal à 1
    if (num > nombreMenu) {
        num = 1;
    }

});

// Si on clique sur la flèche "toggleLeft"
$("#toggleLeft").click(function () {

    // On fait apparaitre le item précédent (num - 1)
    num = num - 1;
    // Si le numéro est inférieur à 0 alors le numéro est égal au nombre de item
    if (num < 1) {
        num = nombreMenu;
    }
});
