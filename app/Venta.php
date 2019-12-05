<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable =[
 
        'idusuario',
        'fecha_hora',
        'impuesto',
        'total',
        'estado'
    ];
}
