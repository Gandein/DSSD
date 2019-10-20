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
          <h2>Solicitud de entrevista o comparendo</h2>
          &nbsp;&nbsp;


          <form autocomplete="off" action="/action_page.php">
            <!-- <div class="form-group autocomplete">
              <label for="">Solicitante</label>
              <input type="text" class="form-control" id="solicitante" placeholder="Nombre del solicitante">
            </div>-->
            <div class="form-row">
              <div class="form-group col-md-6 mb-0">
                <label for="">Solicitante</label>
                <input type="text" class="form-control form-group col-md-6 mb-1" id="solicitante" placeholder="Nombre del solicitante">
              </div>
              <div class="form-group col-md-6">
                <label for="">Rol Solicitante</label>
                <select class="form-control" id="rolSolicitante">
                  <option>Interno</option>
                  <option>Abogado</option>
                  <option>Juez</option>
                  <option>Procurador</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="">Número de causa</label>
              <input type="text" class="form-control" id="numCausa" placeholder="Ingrese número de causa">
            </div>
            <div class="form-row" id="dynamicInput">
              <div class="form-group col-md-6 autocomplete mt-3 mb-0">
                <label for="">Nombre Participante 1</label>
                <input type="text" class="form-control form-group col-md-6" id="nombreParticipante1" placeholder="Nombre del participante">
              </div>
              <div class="form-group col-md-6">
                <label for="">Rol 1</label>
                <select class="form-control" id="rolParticipante1">
                  <option>Interno</option>
                  <option>Abogado</option>
                  <option>Juez</option>
                  <option>Procurador</option>
                </select>
              </div>
            </div>
            <input type="button" value="Agregar otro participante" onClick="addInput();">
            <div class="form-group">
              <label for="">Motivo de la videoconferencia</label>
              <textarea class="form-control" id="motivoConferencia" rows="2"></textarea>
            </div>


            <form method="post" action="?">
              <div>
                <label for="filter-date">Fecha</label>
                <input type="text" name="filter-date" id="filter-date"/>
              </div>

            </form>

            <button type="submit" class="btn btn-primary" onClick="enviarDatos()">Submit</button>
          </form>

        </div>

      </div>
    </div>
    <script src="js/formDinamico.js" language="Javascript" type="text/javascript">></script>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.datetimepicker.full.js"></script>

    <script>
      //ACA HACER PUSH DE LAS FECHAS QUE SE QUIERAN BLOQUEAR
      var bloqueadas = ['14.10.2019','02.01.2014'];
      jQuery(document).ready(function () {
        'use strict';
        jQuery.datetimepicker.setLocale('es');
        jQuery('#filter-date, #search-from-date, #search-to-date').datetimepicker(
          {disabledDates: bloqueadas, formatDate:'d.m.Y'}
        );
      });
    </script>

  </body>
</html>
