<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request){

        $anio = date('Y');
        $ingresos =  DB::table('ingresos as i')
        ->select(DB::raw('MONTH(i.fecha_hora) as mes'),
        DB::raw('YEAR(i.fecha_hora) as anio'),
        DB::raw('SUM(i.total) as total'))
        ->where('i.estado', 'Registrado')
        ->whereYear('i.fecha_hora', $anio)     
        ->groupBy(DB::raw('MONTH(i.fecha_hora)'),DB::raw('YEAR(i.fecha_hora)'))
        
        ->get();

        $ventas =  DB::table('ventas as v')
        ->select(DB::raw('MONTH(v.fecha_hora) as mes'),
        DB::raw('YEAR(v.fecha_hora) as anio'),
        DB::raw('SUM(v.total) as total'))
        ->where('v.estado', 'Registrado')
        ->whereYear('v.fecha_hora', $anio)
        ->groupBy(DB::raw('MONTH(v.fecha_hora)'),DB::raw('YEAR(v.fecha_hora)'))
        ->get();


        return['ingresos' => $ingresos,'ventas' => $ventas ,'anio' => $anio];




    }
}
