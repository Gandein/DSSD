<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DB;

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

      DB::transaction(function () use ($videoConferencia, $request, $estado_no_iniciada) {
        $videoConferencia->save();

        $videoConferencia->participantes()->attach($request->participantes);

        $videoConferencia->estados()->attach($estado_no_iniciada->id, ['descripcion' => "Video conferencia programada"]);
      });

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

    DB::transaction(function () use ($videoconferencia, $inicio, $observaciones_inicio, $fin, $observaciones_final) {
      $videoconferencia->estados()->attach([
        $inicio => ['descripcion' => $observaciones_inicio],
        $fin => ['descripcion' => $observaciones_final]
      ]);
    });
  }

  public function getCantidadEstados()
  {
    $participantes = DB::table('registro_videoconferencia')
      ->join('estado_videoconferencia', 'registro_videoconferencia.estado_videoconferencia_id', '=', 'estado_videoconferencia.id')
      ->select('estado', DB::raw('count(estado_videoconferencia.estado) as cantidad'))
      ->groupBy('estado')
      ->get();

    return $participantes;
  }

  public function getUnidades()
  {
    $unidades = \App\Unidad::all();
    return $unidades;
  }

  public function getExitosasUltimoMes(Request $request)
  {
    $unidad = $request->unidad;

    if (!$unidad) {
      return null;
    }

    $from = date('Y-m-d', strtotime('-30 days'));
    $to = date('Y-m-d', strtotime('0 days'));

    $videoconferencias = DB::table('videoconferencias')
      ->join('tipo_videoconferencia', 'videoconferencias.tipo_id', '=', 'tipo_videoconferencia.id')
      ->join('participantes', 'videoconferencias.solicitante_id', '=', 'participantes.id')
      ->join('registro_videoconferencia', 'videoconferencias.id', '=', 'registro_videoconferencia.videoconferencia_id')
      ->where('unidad_id' , $unidad)
      ->where('fecha', '>', $from)
      ->where('fecha', '<=', $to)
      ->where('estado_videoconferencia_id', '=', 5)
      ->get();

    return $videoconferencias;
  }
}
