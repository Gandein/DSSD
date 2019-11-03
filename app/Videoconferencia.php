<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videoconferencia extends Model
{
  public $timestamps = false;

  public function unidad()
  {
    return $this->belongsTo('\App\Unidad');
  }

  public function estado()
  {
    return $this->belongsTo('\App\EstadoVideoconferencia');
  }

  public function tipo()
  {
    return $this->belongsTo('\App\TipoVideoconferencia');
  }

  public function solicitante()
  {
    return $this->belongsTo('\App\Participante');
  }

  public function participantes()
  {
      return $this->belongsToMany('App\Participante', 'videoconferencia_participante');
  }

  public function estados()
  {
      return $this->belongsToMany('App\EstadoVideoconferencia', 'registro_videoconferencia')->withTimestamps();
  }
}
