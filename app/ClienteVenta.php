<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteVenta extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'id', 'phone'
    ];

    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }

}
