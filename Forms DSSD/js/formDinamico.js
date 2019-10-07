var counter = 1;
var limit = 5;
function addInput(divName){
     if (counter == limit)  {
          alert("Se permiten hasta " + counter + " participantes");
     }
     else {
          var newdiv = document.createElement('div');
          var newdiv2 = document.createElement('div');
          newdiv.innerHTML = "Nombre Participante " + (counter + 1) + " <input type='text' name='losNombres[]' class='form-control form-group col-md-6' id='nombreparticipante' placeholder='Nombre del participante'>";
          newdiv2.innerHTML = "Rol " + (counter + 1) + "<select name='losRoles[]' class='form-control form-group col-md-6' id='nombreParticipante1'><option>Interno</option><option>Abogado</option><option>Juez</option><option>Procurador</option></select>";
          document.getElementById(divName).appendChild(newdiv);
          document.getElementById(divName).appendChild(newdiv2);
          counter++;
     }
}
