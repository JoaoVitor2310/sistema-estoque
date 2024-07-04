<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_reclamacao extends Model
{
    use HasFactory;

    protected $table = 'tipo_reclamacao';

    protected $fillable= [
        'id',
        'nome',
      ];
}
