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
        <h2>¿En qué forma se desarrolló la videollamada?</h2>
        &nbsp;&nbsp;

        <form autocomplete="off" method="post" action="enviarFormEstadosVideoconferencia">
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
            <textarea class="form-control" id="motivoConferencia" name="observaciones_inicio" rows="2"></textarea>
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
            <textarea class="form-control" id="motivoConferencia" name="observaciones_final" rows="2"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>

      </div>

    </div>
  </div>

</body>
</html>
