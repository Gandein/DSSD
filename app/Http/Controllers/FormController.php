<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DateTime;
use \App\Participante;

class FormController extends Controller
{
  protected $client;

  public function __construct()
  {
    //Creo cliente con cookies "compartidas" entre peticiones
    $this->client = new Client(['cookies' => true]);
  }

  public function generarToken()
  {
    $this->client->request('POST', 'http://localhost:8080/bonita/loginservice', [
      'query' => [
        'username' => 'walter.bates',
        'password' => 'bpm',
        'redirect' => false
      ]
    ]);
  }

  public function mostrarForm(Request $request)
  {
    //$request->id; id de la tarea enviado por get, apartir de esta tengo que buscar el caseId
    session(['idTarea' => $request->id]);

    //Logueo
    $this->generarToken();

    //Busco el case id
    $res = $this->client->request('GET','http://localhost:8080/bonita/API/bpm/humanTask/' . $request->id);

    //Decodifico respuesta y obtengo el caseId
    $res = json_decode($res->getBody());
    session(['idCase' => $res->rootCaseId]);

    return view('form');
  }


  //{solicitante: <id>, fecha:<input->type="datetime-local">,participates: [<id1>, <id2>, ...], motivo: <String>, numeroCausa: <String o int> }
  public function enviarForm(Request $request)
  {
    $this->generarToken();
    $solicitante = Participante::with('tipo_participante')->find($request->solicitante);
    $participantes = Participante::with('tipo_participante')->find($request->participantes);

    //Obtengo cookie para enviar como token
    $token = $this->client->getConfig('cookies')->getCookieByName('X-Bonita-API-Token')->getValue();

    //Envio solicitud para cambiar el valor de la variable "unidad"
    $unidad = "";
    //¿El solicitante es el interno?
    if ($solicitante->tipo_participante->tipo == "interno") {
      $unidad = $solicitante->unidad
    }else{
      //Si no es, lo busco entre los participantes
      $interno = $participantes->first(function ($p) {
        return $p->tipo_participante->tipo == "interno";
      });
      $unidad = $interno->unidad;
    }

    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/unidad',
    [
      'json' => [
        'type' => 'java.lang.String',
        'value' => $unidad
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);

    //Envio solicitud para cambiar el valor de la variable "fecha"
    $fecha = new DateTime($request->fecha);
    $fecha =  $fecha->format('D M d H:i:s') . " ART " . $fecha->format('Y');
    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/fecha',
    [
      'json' => [
        'type' => 'java.util.Date',
        'value' => $fecha
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);

    //Envio solicitud para cambiar el valor de la variable "motivo"
    $motivo = $request->motivo;
    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/motivo',
    [
      'json' => [
        'type' => 'java.lang.String',
        'value' => $motivo
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);

    //Envio solicitud para cambiar el valor de la variable "numeroCausa"
    $numeroCausa = $request->numeroCausa
    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/numeroCausa',
    [
      'json' => [
        'type' => 'java.lang.String',
        'value' => $numeroCausa
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);

    //Envio solicitud para cambiar el valor de la variable "participantesSinParsear"
    $participantesSinParsear = "";
    foreach ($participantes as $participante) {
      $participantesSinParsear = $participante->id . "," . $participante->email . "," . $participante->nombre . " " . $participante->apellido . ";";
    }

    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/participantesSinParsear',
    [
      'json' => [
        'type' => 'java.lang.String',
        'value' => $participantesSinParsear
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);

    //Envio solicitud para cambiar el valor de la variable "solicitanteSinParsear"
    $solicitanteSinParsear = $solicitante->id . "," . $solicitante->nombre . " " . $solicitante->apellido . "," . $solicitante->email;

    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/solicitanteSinParsear',
    [
      'json' => [
        'type' => 'java.lang.String',
        'value' => $solicitanteSinParsear
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);

    //Envio solicitud para completar la idTarea
    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/activity/' . session("idTarea"),
    [
      'json' => [
        'state' => 'completed',
        'variables' => '[]'
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);
  }

}
