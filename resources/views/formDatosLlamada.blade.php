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
        <h2>¿En qué forma se desarrolló la videollamada programada para la fecha {{$fecha}}?</h2>
        &nbsp;&nbsp;
        <div class="row">
          <div class="col">
            <div id="alerta" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none">
              <div id="texto_alerta" style="text-align: center;">

              </div>
              <button class="close">
                <span aria-hidden="true" onclick="$('#alerta').css({'display': 'none'})">&times;</span>
              </button>
            </div>
          </div>
        </div>
        <div>
          <div class="form-row">
            <div class="form-group col-md-10">
              <h6 for="">Indique cómo sucedió el inicio de la llamada:</h6>

              @foreach ($estados_inicio as $estado)
                <input type="radio" name="inicioLlamada" value="{{$estado->id}}">{{$estado->estado}}<br>
              @endforeach

            </div>
          </div>
          <div class="form-group">
            <label for="">Registro de las observaciones del inicio</label>
            <textarea class="form-control" id="observaciones_inicio" name="observaciones_inicio" rows="2"></textarea>
          </div>
          <div class="form-row">
            <div class="form-group col-md-10">
              <h6 for="">Indique cómo finalizó la llamada:</h6>

                  @foreach ($estados_fin as $estado)
                    <input type="radio" name="finalLlamada" value="{{$estado->id}}">{{$estado->estado}}<br>
                  @endforeach

            </div>
          </div>
          <div class="form-group">
            <label for="">Registro de las observaciones del final</label>
            <textarea class="form-control" id="observaciones_final" name="observaciones_final" rows="2"></textarea>
          </div>

          <button id="submit" type="submit" class="btn btn-primary">Submit</button>
        </div>

      </div>

    </div>
  </div>
  <script type="text/javascript">
  function enviar() {
    var inicio = $("input[name='inicioLlamada']:checked").val();
    var fin = $("input[name='finalLlamada']:checked").val();
    var observaciones_inicio = $("#observaciones_inicio").val();
    var observaciones_final = $("#observaciones_final").val();

    if (!inicio || !fin || !observaciones_inicio || !observaciones_final) {
      $("#texto_alerta").html("Complete el formulario");
      $("#alerta").css({"display": "block"});
    }

    $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: "enviarFormEstadosVideoconferencia",
      type: "POST",
      data: {inicioLlamada: inicio, finalLlamada: fin, observaciones_inicio: observaciones_inicio, observaciones_final: observaciones_final},
      success: function (result){
        if (result.success) {
          $("body").empty().append('<div class="alert alert-success text-center">La solicitud se envio correctamente</div>');
        } else {
          $("#texto_alerta").html(result.message);
          $("#alerta").css({"display": "block"});
        }
      }
    });
  }
  $("#submit").bind("click", enviar);
  </script>

</body>
</html>
