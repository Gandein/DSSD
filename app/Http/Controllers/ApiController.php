<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
  public function getParticipantes()
  {
    $participantes = \App\Participante::with('tipo_participante')->get();

    return $participantes->makeHidden('tipo_participante_id');
  }
}
