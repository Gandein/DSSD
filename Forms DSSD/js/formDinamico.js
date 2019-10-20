var counter = 1;
var limit = 5;
function addInput(divName){
     if (counter == limit)  {
          alert("Se permiten hasta " + counter + " participantes");
     }
     else {
          var newdiv = document.createElement('div');
          var newdiv2 = document.createElement('div');
          newdiv.className= "form-group col-md-6 autocomplete";
          var inputParticipante = document.createElement('input');
          inputParticipante.id="nombreParticipante" + (counter + 1);
          inputParticipante.type="text";
          inputParticipante.name="losNombres[]";
          inputParticipante.className="form-control";
          inputParticipante.placeholder="Nombre del participante";
          newdiv.innerHTML = "Nombre Participante " + (counter + 1);
          newdiv.appendChild(inputParticipante);
          //var idInput="nombreParticipante" + (counter + 1);
          //newdiv.innerHTML = "Nombre Participante " + (counter + 1) + " <input type='text' name='losNombres[]' class='form-control form-group col-md-6' id={idInput} placeholder='Nombre del participante'>";
          newdiv2.className= "form-group col-md-6";
          newdiv2.innerHTML = "Rol " + (counter + 1) + "<select name='losRoles[]' class='form-control' id='nombreParticipante1'><option>Interno</option><option>Abogado</option><option>Juez</option><option>Procurador</option></select>";
          document.getElementById(divName).appendChild(newdiv);
          document.getElementById(divName).appendChild(newdiv2);
          counter++;
     }
     autocomplete(document.getElementById("nombreParticipante2"), nombres);
     autocomplete(document.getElementById("nombreParticipante3"), nombres);
     autocomplete(document.getElementById("nombreParticipante4"), nombres);
     autocomplete(document.getElementById("nombreParticipante5"), nombres);
}
