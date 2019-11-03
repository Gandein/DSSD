<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

class ApiController extends Controller
{
  public function getParticipantes()
  {
    $participantes = \App\Participante::with('tipo_participante')->get();

    return $participantes->makeHidden('tipo_participante_id');
  }

  public function guardarVideoConferencia(Request $request)
  {
    try {
      $estado_no_iniciada = \App\EstadoVideoconferencia::where('estado', 'no iniciada')->first();
      $solicitante = \App\Participante::with('tipo_participante')->find($request->solicitante);
      $participantes = \App\Participante::with('tipo_participante')->find($request->participantes);
      $unidad = \App\Unidad::find($request->unidad);

      $fecha = new DateTime($request->fecha);
      $fecha =  $fecha->format('Y-m-d');

      $tipoVideoConferencia = "";
      if ($solicitante->tipo_participante->tipo == "juez") {
        $interno = $participantes->first(function ($p) {
          return $p->tipo_participante->tipo == "interno";
        });

        if ($interno) {
          $tipoVideoConferencia = \App\TipoVideoconferencia::where('tipo', 'comparendo')->first();
        }else{
          $tipoVideoConferencia = \App\TipoVideoconferencia::where('tipo', 'entrevista')->first();
        }
      }else{
        $tipoVideoConferencia = \App\TipoVideoconferencia::where('tipo', 'entrevista')->first();
      }

      $videoConferencia = new \App\Videoconferencia;
      $videoConferencia->fecha = $fecha;
      $videoConferencia->hora = $request->hora;
      $videoConferencia->unidad()->associate($unidad);
      $videoConferencia->estado()->associate($estado_no_iniciada);
      $videoConferencia->tipo()->associate($tipoVideoConferencia);
      $videoConferencia->nro_causa = $request->nroCausa;
      $videoConferencia->motivo = $request->motivo;
      $videoConferencia->solicitante()->associate($solicitante);

      $videoConferencia->save();

      $videoConferencia->participantes()->attach($request->participantes);

      $videoConferencia->estados()->attach($estado_no_iniciada->id, ['descripcion' => "Video conferencia programada"]);

      return ["success" => true, "id" => $videoConferencia->id];
    } catch (\Exception $e) {
      return ["success"=>false];
    }
  }

  public function guardarEstadosVideoconferencia(Request $request)
  {
    $idConferencia = $request->idConferencia;
    $inicio = $request->inicio;
    $fin = $request->final;
    $observaciones_inicio = $request->observaciones_inicio;
    $observaciones_final = $request->observaciones_final;

    $videoconferencia = \App\Videoconferencia::find($idConferencia);

    $videoconferencia->estados()->attach([
      $inicio => ['descripcion' => $observaciones_inicio],
      $fin => ['descripcion' => $observaciones_final]
    ]);
  }
}
