<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--<link href="index.css" rel="stylesheet"> -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Artifika" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
</head>

<body>
  <div id="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10 py-3 px-lg-5 border bg-light" id="section">
        <h2>Unidad u horario no disponible</h2>
        &nbsp;&nbsp;
        <h5>La unidad y horario seleccionado no están disponibles. Por favor elija nuevamente entre estas sugerencias</h5>
        &nbsp;&nbsp;
        <div id="alerta" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none">
          <div id="texto_alerta" style="text-align: center;">

          </div>
          <button class="close">
            <span aria-hidden="true" onclick="$('#alerta').css({'display': 'none'})">&times;</span>
          </button>
        </div>
        <form autocomplete="off" action="/action_page.php">
          <!-- <div class="form-group autocomplete">
          <label for="">Solicitante</label>
          <input type="text" class="form-control" id="solicitante" placeholder="Nombre del solicitante">
        </div>-->
        <div class="form-row">

          <div class="form-group col-md-4">
            <label for="">Unidades cercanas sugeridas</label>
            <select class="form-control" id="unidad">
              @foreach ($unidades as $unidad)
                <option value="{{$unidad['id']}}">{{$unidad['nombre']}}</option>
              @endforeach
            </select>
          </div>
        </div>
        &nbsp;
        <form method="post" action="?">
          <div>
            <label for="filter-date">Fecha</label>
            <input type="text" name="filter-date" id="filter-date"/>
          </div>
          &nbsp;
        </form>
        <button type="submit" class="btn btn-primary" onClick="enviarDatos()">Submit</button>
      </form>

    </div>

  </div>
</div>

<script src="js/jquery.js"></script>
<script src="js/jquery.datetimepicker.full.js"></script>

<script>
  //ACA HACER PUSH DE LAS FECHAS QUE SE QUIERAN BLOQUEAR O PERMITIR
  var fechas_disponibles = @json($fechas, JSON_PRETTY_PRINT);
  var calendario = "";
  var fechasPermitidas = Object.keys(fechas_disponibles.find(function(unidad){return unidad.id == $("#unidad").val()}).disponibles);
  var horariosPermitidos = [];
  jQuery(document).ready(function () {
    'use strict';
    jQuery.datetimepicker.setLocale('es');
    calendario = jQuery('#filter-date').datetimepicker({
      allowDates: fechasPermitidas,
      formatDate:'d/m/Y',
      onSelectDate:function(ct,i){
        var dia = (ct.getDate() >= 10) ? ct.getDate() : "0" + ct.getDate();
        var mes = (ct.getMonth() >= 9) ? ct.getMonth() : "0" + ct.getDate();
        var fecha = dia + "/" + (mes + 1) + "/" + ct.getFullYear();
        var unidad = fechas_disponibles.find(function(unidad){return unidad.id == "2"});
        var horarios = unidad.disponibles[fecha];
        $(".xdsoft_time_variant").html("");
        $('#filter-date').datetimepicker({allowTimes: horarios});
      }
    });
  });

  $("#unidad").bind("change", function(){
    var fechasPermitidas = Object.keys(fechas_disponibles.find(function(unidad){return unidad.id == $("#unidad").val()}).disponibles);
    $('#filter-date').datetimepicker({allowDates: fechasPermitidas});
    console.log($("#unidad").val());
    console.log("enrte");
  });

  function enviarDatos() {
    unidad = $("#unidad").val();
    fecha = $("#filter-date").val();
    if (!unidad || !fecha) {
      $("#texto_alerta").html("Ingrese fecha y unidad");
      $("#alerta").css({"display": "block"});
      return;
    }
    hora = fecha.split(" ")[1];
    console.log(hora);
    if (hora != "8:00" && hora != "10:00" && hora != "13:00" && hora != "15:00") {
      $("#texto_alerta").html("Ingrese fecha y unidad");
      $("#alerta").css({"display": "block"});
      return;
    }
    $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: "enviarFormLugaresSugeridos",
      type: "POST",
      data: {unidad: unidad, fecha: fecha}
    });
  }
</script>

</body>
</html>
