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
    $estadosCase=array("started"=> 0,"suspended"=> 0,"cancelled"=> 0,"aborted"=> 0,"completed"=> 0,"error"=> 0,);
    $nombresTareasEjecutandose=array();
    $cantidadTareasEjecutandose=array();
    //$cantidadTareasArchivadas=array();
    //Aca uso la funcion Request::doTheRequest para obtener los distintos datos
    //Cargarlos en una variables $data y enviarla a el template
//var_dump(Request::doTheRequest('GET', 'API/bpm/process?p=0&c=1000'));
//var_dump(Request::doTheRequest('GET', 'API/bpm/case?p=0&c=1000'));
 //var_dump(Request::doTheRequest('GET', 'API/bpm/archivedCase?p=0&c=1000'));
 //var_dump(Request::doTheRequest('GET', 'API/bpm/task?p=0&c=1000'));
//var_dump(Request::doTheRequest('GET', 'API/bpm/archivedTask?p=0&c=1000'));
    //var_dump(count(Request::doTheRequest('GET', 'API/bpm/process?p=0&c=1000')));
  //var_dump(count(Request::doTheRequest('GET', 'API/bpm/case?p=0&c=1000')));
  //var_dump(count(Request::doTheRequest('GET', 'API/bpm/task?p=0&c=1000')));

foreach (Request::doTheRequest('GET', 'API/bpm/case?p=0&c=1000')['data'] as $index => $tarea) {
  $estado = $tarea -> state;
  if($estado == "started"){
    $estadosCase['started']++;
      //var_dump($estadosCase['started']);
  }if($estado == "suspended"){
    $estadosCase['suspended']++;
  }if($estado == "cancelled"){
    $estadosCase['cancelled']++;
  }if($estado == "aborted"){
    $estadosCase['aborted']++;
  }if($estado == "completed"){
    $estadosCase['completed']++;
  }if($estado == "error"){
    $estadosCase['error']++;
  }
  //var_dump($estado);
}

//foreach (Request::doTheRequest('GET', 'API/bpm/task?p=0&c=1000')['data'] as $index => $tarea) {
  //$nombreTarea = $tarea -> displayName;
  //if(!array_key_exists($nombreTarea,$nombresTareasEjecutandose)){
  //$cantidadTareasEjecutandose[$nombreTarea]= 0;
    //$cantidadTareasEjecutandose[$nombreTarea]++;
    //array_push($nombresTareasEjecutandose,$nombreTarea);
//}else {
  //$cantidadTareasEjecutandose[$nombreTarea]++;
  //}

foreach (Request::doTheRequest('GET', 'API/bpm/task?p=0&c=1000')['data'] as $index => $tarea) {
  $nombreTarea = $tarea -> displayName;
  if(!array_key_exists($nombreTarea,$cantidadTareasEjecutandose)){
  $cantidadTareasEjecutandose[$nombreTarea]= 0;
    $cantidadTareasEjecutandose[$nombreTarea]++;
    array_push($nombresTareasEjecutandose,$nombreTarea);
  //var_dump($cantidadTareas[$nombreTarea]);
}else {
  $cantidadTareasEjecutandose[$nombreTarea]++;
  //var_dump($cantidadTareas[$nombreTarea]);
}

}
var_dump($nombresTareasEjecutandose);
$tareas =Request::doTheRequest('GET', 'API/bpm/task?p=0&c=1000')['data'];
var_dump(Request::doTheRequest('GET', 'API/bpm/task?p=0&c=1000'));


//$response = $client->request('GET', 'http://localhost/DSSD/public/api/cantidadEstados');
//var_dump($response);
//debug.Log($response);
//var_dump(Request::doTheRequest('GET', 'http://localhost/DSSD/public/api/cantidadEstados')['data']);
$estadosLlamadas = Request::doTheRequest('GET', 'http://localhost/DSSD/public/api/cantidadEstados')['data'];
//var_dump(Request::doTheRequest('GET', 'http://localhost/DSSD/public/api/unidades'));
//var_dump(Request::doTheRequest('GET', 'http://localhost/DSSD/public/api/exitosasUltimoMes?unidad=2'));
//$string = "http://localhost/DSSD/public/api/exitosasUltimoMes?unidad=2";
//$string= substr_replace("http://localhost/DSSD/public/api/exitosasUltimoMes?unidad=","2",59,0);
//var_dump(Request::doTheRequest('GET', $string));


//console.Log(Request::doTheRequest('GET', 'http://localhost/DSSD/public/api/cantidadEstados'));

//'displayName' => string 'Ingreso de informacion de videollamada';

$data = ["casos" => count(Request::doTheRequest('GET', 'API/bpm/case?p=0&c=1000')['data']),
"tareas" => count(Request::doTheRequest('GET', 'API/bpm/task?p=0&c=1000')['data']),
"procesos" => count(Request::doTheRequest('GET', 'API/bpm/process?p=0&c=1000')['data']),
"estadosCase" => $estadosCase,
"cantidadTareasEjecutandose" => $cantidadTareasEjecutandose,
"tareasEjecutandose" => $nombresTareasEjecutandose,
'estadosLlamadas' => $estadosLlamadas]; //La clave del array se accede como variable en templates/inicio.twig
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
