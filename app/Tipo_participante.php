<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_participante extends Model
{
  /*Para que eloquent no espere las columnas created_at y updated_at*/
  public $timestamps = false;
  /*Le digo el nombre de la tabla, ya que Eloquent asume que la tabla es tipo_participantes*/
  protected $table = 'tipo_participante';
}
