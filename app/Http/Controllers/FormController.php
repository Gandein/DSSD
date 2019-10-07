<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class FormController extends Controller
{
  protected $client;

  public function __construct()
  {
    //Creo cliente con cookies "compartidas" entre peticiones
    $this->client = new Client(['cookies' => true]);
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

    //Obtengo cookie para enviar como token
    $token = $this->client->getConfig('cookies')->getCookieByName('X-Bonita-API-Token')->getValue();

    //Envio solicitud para cambiar el valor de la variable "lugar"
    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/lugar',
    [
      'json' => [
        'type' => 'java.lang.String',
        'value' => 'unLugar'
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);

    //Envio solicitud para cambiar el valor de la variable "fecha"
    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/fecha',
    [
      'json' => [
        'type' => 'java.util.Date',
        'value' => 'Mon Sep 30 15:02:08 ART 2019'
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);

    //Envio solicitud para cambiar el valor de la variable "motivo"
    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/motivo',
    [
      'json' => [
        'type' => 'java.lang.String',
        'value' => 'un Motivo'
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);

    //Envio solicitud para cambiar el valor de la variable "numeroCausa"
    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/numeroCausa',
    [
      'json' => [
        'type' => 'java.lang.String',
        'value' => 'unNumeroCausa'
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);

    //Envio solicitud para cambiar el valor de la variable "participantesSinParsear"
    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/participantesSinParsear',
    [
      'json' => [
        'type' => 'java.lang.String',
        'value' => 'id1,nombre1,email1;id2,nombre2,email2;id3,nombre3,email3'
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);

    //Envio solicitud para cambiar el valor de la variable "solicitanteSinParsear"
    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/' . session("idCase") . '/solicitanteSinParsear',
    [
      'json' => [
        'type' => 'java.lang.String',
        'value' => 'idSolicitane,nombreSolicitante,emailSolicitante'
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

    return view('form');
  }

  public function enviarForm()
  {
    return "asd";
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

  public function obtenerVariable()
  {

  }

}
