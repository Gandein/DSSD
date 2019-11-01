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

  }

  public function mostrarFormDatosConferencia(Request $request)
  {
    //$request->id; id de la tarea enviado por get, apartir de esta tengo que buscar el caseId
    session(['idTarea' => $request->id]);

    //Busco el case id
    $res = RequestBonita::doTheRequest("GET", "API/bpm/humanTask/" . $request->id);

    if ($res["success"]) {
      session(['idCase' => $res["data"]->rootCaseId]);
    }else {
      //Controlar error
      return "error";
    }


    return view('form');
  }


  //{solicitante: <id>, fecha:<input->type="datetime-local">,participates: [<id1>, <id2>, ...], motivo: <String>, numeroCausa: <String o int> }
  public function enviarForm(Request $request)
  {
    $solicitante = Participante::with('tipo_participante')->find($request->solicitante);
    $participantes = Participante::with('tipo_participante')->find($request->participantes);

    //Envio solicitud para cambiar el valor de la variable "unidad"
    $unidad = "";
    //¿El solicitante es el interno?
    if ($solicitante->tipo_participante->tipo == "interno") {
      $unidad = $solicitante->unidad;
    }else{
      //Si no es, lo busco entre los participantes
      $interno = $participantes->first(function ($p) {
        return $p->tipo_participante->tipo == "interno";
      });
      $unidad = $interno->unidad;
    }

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/unidad', ['type' => 'java.lang.String','value' => $unidad]);

    //Envio solicitud para cambiar el valor de la variable "fecha"
    $fecha = new DateTime($request->fecha);
    $fecha =  $fecha->format('D M d H:i:s') . " ART " . $fecha->format('Y');

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/fecha', ['type' => 'java.util.Date','value' => $fecha]);

    //Envio solicitud para cambiar el valor de la variable "motivo"
    $motivo = $request->motivo;

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/motivo', ['type' => 'java.lang.String','value' => $motivo]);

    //Envio solicitud para cambiar el valor de la variable "numeroCausa"
    $numeroCausa = $request->numeroCausa;

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/numeroCausa', ['type' => 'java.lang.String','value' => $numeroCausa]);

    //Envio solicitud para cambiar el valor de la variable "participantesSinParsear"
    $participantesSinParsear = "";
    foreach ($participantes as $participante) {
      $participantesSinParsear = $participantesSinParsear . $participante->id . "," . $participante->nombre . " " . $participante->apellido . "," . $participante->email . ";";
    }

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/participantesSinParsear', ['type' => 'java.lang.String','value' => $participantesSinParsear]);

    //Envio solicitud para cambiar el valor de la variable "solicitanteSinParsear"
    $solicitanteSinParsear = $solicitante->id . "," . $solicitante->nombre . " " . $solicitante->apellido . "," . $solicitante->email;

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/solicitanteSinParsear', ['type' => 'java.lang.String','value' => $solicitanteSinParsear]);

    //Envio solicitud para completar la idTarea
    $res = RequestBonita::doTheRequest("PUT", "API/bpm/activity/" . session("idTarea"), ['state' => 'completed','variables' => '[]']);

    return ["estado" => "ok"];
  }

  public function mostrarFormLugaresSugeridos()
  {
    // code...
  }

  public function enviarFormLugaresSugeridos()
  {
    // code...
  }
}
