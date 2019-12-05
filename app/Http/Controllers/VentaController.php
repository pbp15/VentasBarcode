<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Venta;
use App\DetalleVenta;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $ventas = Venta::join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.fecha_hora','ventas.impuesto','ventas.total',
            'ventas.estado','users.usuario')
            ->orderBy('ventas.id', 'desc')->paginate(15);
        }
        else{
            $ventas = Venta::join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.fecha_hora','ventas.impuesto','ventas.total',
            'ventas.estado','users.usuario')
            ->where('ventas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ventas.id', 'desc')->paginate(15);
        }
        
        return [
            'pagination' => [
                'total'        => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page'     => $ventas->perPage(),
                'last_page'    => $ventas->lastPage(),
                'from'         => $ventas->firstItem(),
                'to'           => $ventas->lastItem(),
            ],
            'ventas' => $ventas
        ];
    }
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $venta = Venta::join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.fecha_hora','ventas.impuesto','ventas.total',
        'ventas.estado','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();
        
        return ['venta' => $venta];
    }
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento',
        'articulos.nombre as articulo')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();
        
        return ['detalles' => $detalles];
    }
    public function pdf(Request $request,$id){
             $venta = Venta::join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.created_at' ,'ventas.fecha_hora',
            'ventas.impuesto','ventas.total','ventas.estado','users.usuario')
            ->where('ventas.id','=',$id)
            ->orderBy('ventas.id', 'desc')->take(1)->get();

            $detalles = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
            ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento',
            'articulos.nombre as articulo')
            ->where('detalle_ventas.idventa','=',$id)
            ->orderBy('detalle_ventas.id', 'desc')->get();

            $numventa = Venta::select('fecha_hora')->where('id',$id)->get();

            $pdf= \PDF::loadview('pdf.venta',['venta'=>$venta,'detalles'=>$detalles]);
            return $pdf->stream('venta-'.$numventa[0]->fecha_hora.'.pdf');


    }


    public function pdfVentaTotal(){

        $ventaTotal = Venta::join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.fecha_hora',
            'ventas.impuesto','ventas.total','ventas.estado','users.usuario')
            ->where('ventas.estado', 'Registrado')
            ->orderBy('ventas.id', 'desc')->get();             

            $cont=Venta::where('ventas.estado', 'Registrado')
            ->count();
            
            $total= DB::table('ventas as v')
            ->select(DB::raw('SUM(v.total) as total'))
            ->where('v.estado', 'Registrado')->get();

            $pdf = \PDF::loadview('pdf.VentaTotal',['ventaTotal'=>$ventaTotal,'cont' =>$cont ,'total' =>$total]);
            return $pdf->stream('VentaTotal.pdf');

    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            $venta = new Venta();
            $venta->idusuario = \Auth::user()->id;
            $venta->fecha_hora = $mytime ->toDateTimeString();
            $venta->impuesto = $request->impuesto;
            $venta->total = $request->total;
            $venta->estado = 'Registrado';
            $venta->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->id;
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->descuento = $det['descuento'];         
                $detalle->save();
            }          

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $venta = Venta::findOrFail($request->id);
        $venta->estado = 'Anulado';
        $venta->save();
    }
}
