var participantes = "";

function enviarDatos() {

  var idSolicitante = document.getElementById('solicitante').data_id;
  var numeroCausa = document.getElementById('numCausa').value;
  var idParticipantes = $("#dynamicInput > .form-group.col-md-6.autocomplete > input").map(function(){return this.data_id}).get();
  var motivoDeConferencia = document.getElementById('motivoConferencia').value;
  var fecha = document.getElementById('filter-date').value;

  if (!idSolicitante || !numeroCausa || !participantes.length || !motivoConferencia || !fecha) {
    alert("Formulario incompleto");
    return;
  }else{
    var hora = fecha.split(" ")[1];
    if (hora != "08:00" && hora != "10:00" && hora != "13:00" && hora != "15:00"){
      alert("Fecha incorrecta");
      return;
    }
  }

  $.ajax({
    url: "http://localhost/DSSD/public/enviarForm",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "POST",
    dataType:"json",
    data:{solicitante: idSolicitante, fecha: fecha, participantes: idParticipantes, motivo: motivoDeConferencia, numeroCausa: numeroCausa },
    success: function(data){
      if (data.success) {
        $("body").empty().append('<div class="alert alert-success text-center">La solicitud se envio correctamente</div>');
      }else{
        alert(data.message);
      }

    }
  });

}

function autocomplete(inp, participantes) {
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
    listaDeOpciones = document.createElement("DIV");
    listaDeOpciones.setAttribute("id", this.id + "autocomplete-list");
    listaDeOpciones.setAttribute("class", "autocomplete-items");
    /*append the DIV element as a child of the autocomplete container:*/
    this.parentNode.appendChild(listaDeOpciones);
    /*for each item in the array...*/
    for (i = 0; i < participantes.length; i++) {
      /*check if the item starts with the same letters as the text field value:*/
        if (this.id.includes("Participante")) {
          idRol = this.id.replace("nombre", "rol");
          rol = $("#" + idRol).val().toLowerCase();
          if (rol == participantes[i].tipo_participante.tipo.toLowerCase() && participantes[i].nombre_completo.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            /*create a DIV element for each matching element:*/
            opcion = document.createElement("DIV");
            /*make the matching letters bold:*/
            opcion.innerHTML = "<strong>" + participantes[i].nombre_completo.substr(0, val.length) + "</strong>";
            opcion.innerHTML += participantes[i].nombre_completo.substr(val.length);

            opcion.data_id = participantes[i].id;
            opcion.data_nombre_completo = participantes[i].nombre_completo;

            opcion.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.data_nombre_completo;
              inp.data_id = this.data_id;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
            });
            listaDeOpciones.appendChild(opcion);
          }
        } else {;
          rol = $("#rolSolicitante").val().toLowerCase();
          if (rol == participantes[i].tipo_participante.tipo.toLowerCase() && participantes[i].nombre_completo.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            /*create a DIV element for each matching element:*/
            opcion = document.createElement("DIV");
            /*make the matching letters bold:*/
            opcion.innerHTML = "<strong>" + participantes[i].nombre_completo.substr(0, val.length) + "</strong>";
            opcion.innerHTML += participantes[i].nombre_completo.substr(val.length);

            opcion.data_id = participantes[i].id;
            opcion.data_nombre_completo = participantes[i].nombre_completo;

            opcion.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.data_nombre_completo;
              inp.data_id = this.data_id;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
            });
            listaDeOpciones.appendChild(opcion);
        }
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

var counter = 1;
var limit = 5;
function addInput(){
     if (counter == limit)  {
          alert("Se permiten hasta " + counter + " participantes");
     }
     else {
          var divParticipante = document.createElement('div');
          var divRol = document.createElement('div');
          divParticipante.className= "form-group col-md-6 autocomplete";
          var inputParticipante = document.createElement('input');
          inputParticipante.id="nombreParticipante" + (counter + 1);
          inputParticipante.type="text";
          //inputParticipante.name="losNombres[]";
          inputParticipante.className="form-control";
          inputParticipante.placeholder="Nombre del participante";
          divParticipante.innerHTML = "<label>Nombre Participante " + (counter + 1) + "</label>";
          divParticipante.appendChild(inputParticipante);
          //var idInput="nombreParticipante" + (counter + 1);
          //newdiv.innerHTML = "Nombre Participante " + (counter + 1) + " <input type='text' name='losNombres[]' class='form-control form-group col-md-6' id={idInput} placeholder='Nombre del participante'>";
          divRol.className = "form-group col-md-6";
          divRol.innerHTML = "<label>Rol " + (counter + 1) + "</label> <select onchange='on_change_rol( event, this );' class='form-control' id='rolParticipante"+ (counter + 1) +"'><option value=''></option><option>Interno</option><option>Abogado</option><option>Juez</option><option>Procurador</option></select>";
          document.getElementById('dynamicInput').appendChild(divRol);
          document.getElementById('dynamicInput').appendChild(divParticipante);
          counter++;
          autocomplete(document.getElementById(inputParticipante.id), participantes);
     }
}

//Obtengo datos y creo las listas de autocompletado
$.ajax({
  url: "http://localhost/DSSD/public/api/participantes",
  type: "GET",
  dataType: "json",
  success: function(partis){
    participantes = partis;

    participantes.forEach(function (p) {
      p.nombre_completo = p.nombre + " " + p.apellido;
    });

    autocomplete(document.getElementById("nombreParticipante1"), participantes);
    autocomplete(document.getElementById("solicitante"), participantes);
  }
});

var interno_seleccionado = false;
var idSelect;
function on_change_rol(e){
  if (!interno_seleccionado && e.target.value == "Interno") {
    interno_seleccionado = true;
    idSelect = e.target.id;
  } else if (interno_seleccionado && e.target.value == "Interno" && e.target.id != idSelect) {
    e.target.value = null;
    alert("Ya se selecciono interno")
  } else if (e.target.id == idSelect && this.value != "Interno"){
    interno_seleccionado = false;
    idSelect = null;
  }
  if (e.target.id == "rolSolicitante") {
    $("#solicitante").val(null);
  }else{
    $("#" + e.target.id.replace("rol","nombre")).val(null);
  }

}
$("#rolSolicitante").on("change", function(e){on_change_rol(e)});
$("#rolParticipante1").on("change", function(e){on_change_rol(e)});

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
console.log(document.getElementById("nombreParticipante1"));
