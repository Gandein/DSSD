var todoElJson = [{"id":1,"apellido":"Interno1","nombre":"Interno1","email":"repint1@gmail.com","unidad":1,"tipo_participante":{"id":1,"tipo":"interno"}},{"id":2,"apellido":"Interno2","nombre":"Interno2","email":"repint2@gmail.com","unidad":1,"tipo_participante":{"id":1,"tipo":"interno"}},{"id":3,"apellido":"Interno3","nombre":"Interno3","email":"repint3@gmail.com","unidad":2,"tipo_participante":{"id":1,"tipo":"interno"}},{"id":4,"apellido":"Interno4","nombre":"Interno4","email":"repint4@gmail.com","unidad":2,"tipo_participante":{"id":1,"tipo":"interno"}},{"id":5,"apellido":"Interno5","nombre":"Interno5","email":"repint5@gmail.com","unidad":3,"tipo_participante":{"id":1,"tipo":"interno"}},{"id":6,"apellido":"Interno6","nombre":"Interno6","email":"repint6@gmail.com","unidad":3,"tipo_participante":{"id":1,"tipo":"interno"}},{"id":7,"apellido":"Interno7","nombre":"Interno7","email":"repint7@gmail.com","unidad":4,"tipo_participante":{"id":1,"tipo":"interno"}},{"id":8,"apellido":"Interno8","nombre":"Interno8","email":"repint8@gmail.com","unidad":4,"tipo_participante":{"id":1,"tipo":"interno"}},{"id":9,"apellido":"Interno9","nombre":"Interno9","email":"repint9@gmail.com","unidad":4,"tipo_participante":{"id":1,"tipo":"interno"}},{"id":10,"apellido":"Abogado1","nombre":"Abogado1","email":"abg1@gmail.com","unidad":null,"tipo_participante":{"id":2,"tipo":"abogado"}},{"id":11,"apellido":"Abogado2","nombre":"Abogado2","email":"abg2@gmail.com","unidad":null,"tipo_participante":{"id":2,"tipo":"abogado"}},{"id":12,"apellido":"Juez1","nombre":"Juez1","email":"juez1@gmail.com","unidad":null,"tipo_participante":{"id":3,"tipo":"juez"}},{"id":13,"apellido":"Juez2","nombre":"Juez2","email":"juez2@gmail.com","unidad":null,"tipo_participante":{"id":3,"tipo":"juez"}},{"id":14,"apellido":"Procurador1","nombre":"Procurador1","email":"prc1@gmail.com","unidad":null,"tipo_participante":{"id":4,"tipo":"procurador"}},{"id":15,"apellido":"Procurador2","nombre":"Procurador2","email":"prc2@gmail.com","unidad":null,"tipo_participante":{"id":4,"tipo":"procurador"}}];

//ESTO TIRA ERROR DE ACCESO CORS
//var todoElJson = $.getJSON("http://localhost/DSSD/public/api/participantes");
//console.console.log(todoElJson);
//var ids = new Array();
//for (i in todoElJson){ ids.push(todoElJson[i].id);}

function enviarDatos() {

var fecha = document.getElementById('filter-date').value;
var nombreSolicitante = document.getElementById('solicitante').value;
var nombreDelParticipante1 = document.getElementById('nombreParticipante').value;
var nombreDelParticipante2 = document.getElementById('nombreParticipante2').value;
var nombreDelParticipante3 = document.getElementById('nombreParticipante3').value;
var nombreDelParticipante4 = document.getElementById('nombreParticipante4').value;
var nombreDelParticipante5 = document.getElementById('nombreParticipante5').value;
var idParticipante1, idParticipante2,idParticipante3,idParticipante4,idParticipante5,idSolicitante;

for (i in todoElJson){
  if(todoElJson[i].nombre == nombreSolicitante){
    idSolicitante =todoElJson[i].id;
  }
  if(todoElJson[i].nombre == nombreDelParticipante1){
    idParticipante1 =todoElJson[i].id;
  }
  if(todoElJson[i].nombre == nombreDelParticipante2){
    idParticipante2 =todoElJson[i].id;
  }
  if(todoElJson[i].nombre == nombreDelParticipante3){
    idParticipante3 =todoElJson[i].id;
  }
  if(todoElJson[i].nombre == nombreDelParticipante4){
    idParticipante4 =todoElJson[i].id;
  }
  if(todoElJson[i].nombre == nombreDelParticipante5){
    idParticipante5 =todoElJson[i].id;
  }
}
var motivoDeConferencia = document.getElementById('motivoConferencia').value;
var numeroCausa = document.getElementById('numCausa').value;


var request =$.ajax({
type: "POST",
url: "ACA NO SABRIA QUE URL PONER AHORA MISMO",
dataType:"html",
//data:{solicitante: <idSolicitante>, fecha:<fecha->type="datetime-local">,participates: [<idParticipante1>, <idParticipante2>,
//<idParticipante3>,<idParticipante4>,<idParticipante5>], motivo: <motivoDeConferencia>, numeroCausa: <numeroCausa> }
});

}



function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/

var nombres = new Array();
for (i in todoElJson){ nombres.push(todoElJson[i].apellido);}

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("nombreParticipante"), nombres);
autocomplete(document.getElementById("solicitante"), nombres);
console.log(document.getElementById("nombreParticipante"));
