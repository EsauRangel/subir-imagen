<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cati extends Model
{
    use HasFactory;

    protected $fillable = [
        'img',
        'descripcion',
        'visible',
        'prioridad',
        'retroalimentacion',
        'asunto',
        'acciones_corr',
        'usuario_id',
        'atendio_id',
        'usuario_asign_id',
        'rendimiento_id',
        'categoria_id',
        'incidencia_id',
        'tipo_id',
        'status_id',
        'hardware_id',
        'div_equipo_id',
        'close_at',
        'updated_at',
        'created_at'
    ];
}
