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
          <form autocomplete="off" action="/action_page.php">
            <!-- <div class="form-group autocomplete">
              <label for="">Solicitante</label>
              <input type="text" class="form-control" id="solicitante" placeholder="Nombre del solicitante">
            </div>-->
            <div class="form-row">

              <div class="form-group col-md-4">
                <label for="">Unidades cercanas sugeridas</label>
                <select class="form-control" id="unidad">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
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
    <script src="js/formDinamico.js" language="Javascript" type="text/javascript">></script>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.datetimepicker.full.js"></script>

    <script>
        //ACA HACER PUSH DE LAS FECHAS QUE SE QUIERAN BLOQUEAR O PERMITIR
    var fechasBloqueadas = ['14.10.2019','02.01.2014'];
    var fechasPermitidas = ['21.10.2019', '23.10.2019'];
    var horariosPermitidos = ['12:00','13:10'];
        jQuery(document).ready(function () {
            'use strict';
    jQuery.datetimepicker.setLocale('es');
            jQuery('#filter-date, #search-from-date, #search-to-date').datetimepicker(
              {disabledDates: fechasBloqueadas,allowDates: fechasPermitidas,allowTimes: horariosPermitidos, formatDate:'d.m.Y'}
            );
        });
    </script>

  </body>
</html>
