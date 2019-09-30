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
    //echo $res->rootCaseId;

    //Obtengo cookie para enviar como token
    $token = $this->client->getConfig('cookies')->getCookieByName('X-Bonita-API-Token')->getValue();

    //Envio solicitud para cambiar el valor de la variable "emailprueba" del caso 1003
    $res = $this->client->request('PUT','http://localhost:8080/bonita/API/bpm/caseVariable/1003/emailprueba',
    [
      'json' => [
        'type' => 'java.lang.String',
        'value' => 'casa'
      ],
      'headers'=>[
        'X-Bonita-API-Token' => $token
      ]
    ]);
    //return view('form');
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
