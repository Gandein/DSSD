<?php
namespace Monitor;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Cookie\SessionCookieJar;
use GuzzleHttp\Cookie\CookieJar;

class InicioController
{

  public static function inicio(){
    //Aca uso la funcion Request::doTheRequest para obtener los distintos datos
    //Cargarlos en una variables $data y enviarla a el template
var_dump(Request::doTheRequest('GET', 'API/bpm/process?p=0&c=1000'));
var_dump(Request::doTheRequest('GET', 'API/bpm/case?p=0&c=1000'));
 var_dump(Request::doTheRequest('GET', 'API/bpm/archivedCase?p=0&c=1000'));
 var_dump(Request::doTheRequest('GET', 'API/bpm/task?p=0&c=1000'));
  var_dump(Request::doTheRequest('GET', 'API/bpm/archivedTask?p=0&c=1000'));
  //return count($response['data']);
  var_dump(count(Request::doTheRequest('GET', 'API/bpm/process?p=0&c=1000')));
  var_dump(count(Request::doTheRequest('GET', 'API/bpm/case?p=0&c=1000')));
  var_dump(count(Request::doTheRequest('GET', 'API/bpm/task?p=0&c=1000')));

    $data = ["casos" => count(Request::doTheRequest('GET', 'API/bpm/case?p=0&c=1000')['data']),"tareas" => count(Request::doTheRequest('GET', 'API/bpm/task?p=0&c=1000')['data']),"procesos" => count(Request::doTheRequest('GET', 'API/bpm/process?p=0&c=1000')['data'])]; //La clave del array se accede como variable en templates/inicio.twig
    View::showInicio($data);

  }
}
  ?>
  <html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
</head>

<body>

</body>
</html>
