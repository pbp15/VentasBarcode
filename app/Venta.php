<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable =[
        'idcliente', 
        'idusuario',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total',
        'estado'
    ];
}
