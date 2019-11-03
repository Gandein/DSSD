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

  public function mostrarFormEstadosVideconferencias(Request $request)
  {
    session(['idTarea' => $request->id]);
    $estados_inicio = \App\EstadoVideoconferencia::where('etapa', 'inicio')->get();
    $estados_fin = \App\EstadoVideoconferencia::where('etapa', 'final')->get();

    return view('formDatosLlamada', ["estados_inicio" => $estados_inicio, "estados_fin" => $estados_fin]);
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

  public function mostrarFormLugaresSugeridos(Request $request)
  {
    session(['idTarea' => $request->id]);

    $res = RequestBonita::doTheRequest("GET", "API/bpm/caseVariable/" . session("idCase") . "/lugares_sugeridos");
    $res = json_decode($res["data"]->value);

    $unidades = [];
    foreach ($res as $index => $unidad) {
      $unidades[] = ["id" => $unidad->id, "nombre" => $unidad->nombreunidad];
    }

    return view('formNuevaSeleccion', ["fechas" => $res, "unidades" => $unidades]);
  }

  public function enviarFormEstadosVideoconferencia(Request $request)
  {
    $id_inicio = $request->inicioLlamada;
    $id_fin = $request->finalLlamada;
    $observaciones_inicio = $request->observaciones_inicio;
    $observaciones_final = $request->observaciones_final;

    $estado_inicio = \App\EstadoVideoconferencia::find($id_inicio)->estado;
    $estado_fin = \App\EstadoVideoconferencia::find($id_fin)->estado;

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/id_fin_videoconferencia', ['type' => 'java.lang.String','value' => $id_inicio]);

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/id_inicio_videoconferencia', ['type' => 'java.lang.String','value' => $id_fin]);

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/fin_videoconferencia', ['type' => 'java.lang.String','value' => $estado_inicio]);

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/inicio_videoconferencia', ['type' => 'java.lang.String','value' => $estado_fin]);

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/observaciones_inicio', ['type' => 'java.lang.String','value' => $observaciones_inicio]);

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/observaciones_fin', ['type' => 'java.lang.String','value' => $observaciones_final]);

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/activity/" . session("idTarea"), ['state' => 'completed','variables' => '[]']);
  }

  public function enviarFormLugaresSugeridos(Request $request)
  {
    $nueva_unidad = $request->unidad;

    $nueva_fecha = new DateTime($request->fecha);
    $nueva_fecha =  $nueva_fecha->format('D M d H:i:s') . " ART " . $nueva_fecha->format('Y');

    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/unidad', ['type' => 'java.lang.String','value' => $nueva_unidad]);
    $res = RequestBonita::doTheRequest("PUT", "API/bpm/caseVariable/" . session("idCase") . '/fecha', ['type' => 'java.util.Date','value' => $nueva_fecha]);

    //Envio solicitud para completar la idTarea
    $res = RequestBonita::doTheRequest("PUT", "API/bpm/activity/" . session("idTarea"), ['state' => 'completed','variables' => '[]']);
  }
}
