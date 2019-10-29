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

        <form autocomplete="off" action="/action_page.php">
          <div class="form-row">
            <div class="form-group col-md-10">
              <h6 for="">Indique cómo sucedió el inicio de la llamada:</h6>

                  <input type="radio" name="inicioLlamada" value="iniciadaEnTermino" checked> Iniciada en término<br>

                  <input type="radio" name="inicioLlamada" value="iniciadaConDemora"> Iniciada con demora<br>

                  <input type="radio" name="inicioLlamada" value="noIniciada"> No iniciada<br>

                  <input type="radio" name="inicioLlamada" value="suspendida"> Suspendida<br>

            </div>
            <div class="form-group col-md-10">
              <h6 for="">Indique cómo finalizó la llamada:</h6>

                  <input type="radio" name="finalLlamada" value="conDemora" checked> Finalizada con demora<br>

                  <input type="radio" name="finalLlamada" value="problemaTecnico"> Interrumpida por un problema técnico<br>

                  <input type="radio" name="finalLlamada" value="comportamientoDelInterno"> Interrumpida por comportamiento del interno<br>
            </div>
          </div>
          <div class="form-group">
            <label for="">Registro de las observaciones</label>
            <textarea class="form-control" id="motivoConferencia" rows="2"></textarea>
          </div>

          <button type="submit" class="btn btn-primary" onClick="enviarDatos()">Submit</button>
        </form>

      </div>

    </div>
  </div>

</body>
</html>
