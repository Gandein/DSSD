<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroVideoconferencia extends Model
{
  public $timestamps = false;
  protected $table = 'registro_videoconferencia';

  public function estado_videoconferencia()
  {
    return $this->belongsTo('\App\EstadoVideoconferencia');
  }
}
