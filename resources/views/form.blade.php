<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--<link href="index.css" rel="stylesheet"> -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Artifika" rel="stylesheet">

</head>

<body>

  <div id="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10 col-sm-10 col-xs-10 py-3 px-lg-5 border bg-light" id="section">
        <h2>Solicitud de entrevista o comparendo</h2>
        &nbsp;&nbsp;


        <form action="enviarForm">
          <div class="form-group">
            <label for="">Solicitante</label>
            <input type="text" class="form-control" id="solicitante" placeholder="Nombre del solicitante">
            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
            </div>
                      <div class="form-group">
            <label for="">Número de causa</label>
            <input type="text" class="form-control" id="numCausa" placeholder="Ingrese número de causa">
          </div>


          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="">Nombre Participante</label>
              <input type="text" class="form-control" id="nombreParticipante1" placeholder="Nombre del participante">
            </div>
            <div class="form-group col-md-6">
              <label for="">Rol</label>
              <select class="form-control" id="rolParticipante1">
                <option>Interno</option>
                <option>Abogado</option>
                <option>Juez</option>
                <option>Procurador</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="">Nombre Participante</label>
              <input type="text" class="form-control" id="nombreParticipante2" placeholder="Nombre del participante">
            </div>
            <div class="form-group col-md-6">
              <label for="">Rol</label>
              <select class="form-control" id="rolParticipante2">
                <option>Interno</option>
                <option>Abogado</option>
                <option>Juez</option>
                <option>Procurador</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="">Nombre Participante</label>
              <input type="text" class="form-control" id="nombreParticipante3" placeholder="Nombre del participante">
            </div>
            <div class="form-group col-md-6">
              <label for="">Rol</label>
              <select class="form-control" id="rolParticipante3">
                <option>Interno</option>
                <option>Abogado</option>
                <option>Juez</option>
                <option>Procurador</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="">Nombre Participante</label>
              <input type="text" class="form-control" id="nombreParticipante4" placeholder="Nombre del participante">
            </div>
            <div class="form-group col-md-6">
              <label for="">Rol</label>
              <select class="form-control" id="rolParticipante4">
                <option>Interno</option>
                <option>Abogado</option>
                <option>Juez</option>
                <option>Procurador</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="">Motivo de la videoconferencia</label>
            <textarea class="form-control" id="motivoConferencia" rows="2"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>

        </form>

      </div>

    </div>

  </body>
  </html>
