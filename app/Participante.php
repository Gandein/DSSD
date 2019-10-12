<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
  /*Para que eloquent no espere las columnas created_at y updated_at*/
  public $timestamps = false;

  public function tipo_participante()
  {
    return $this->belongsTo('\App\Tipo_participante');
  }
}
