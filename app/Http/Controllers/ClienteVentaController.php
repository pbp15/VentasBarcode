<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\ClienteVenta;
use App\Persona;

class ClienteVentaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $personas = ClienteVenta::join('personas','clientes.id','=','personas.id')
            ->select('personas.id','personas.nombre','clientes.phone')
            ->orderBy('personas.id', 'desc')->paginate(15);
        }
        else{
            $personas = ClienteVenta::join('personas','clientes.id','=','personas.id')
            ->select('personas.id','personas.nombre','clientes.phone')            
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('personas.id', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function selectClienteVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $clientes = ClienteVenta::join('personas','clientes.id','=','personas.id')
        ->where('personas.nombre', 'like', '%'. $filtro . '%')
        ->select('personas.id','personas.nombre')
        ->orderBy('personas.nombre', 'asc')->get();

        return ['clientes' => $clientes];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;           
            $persona->save();

            $cliente = new ClienteVenta();
            $cliente->phone = $request->phone;
            $cliente->id = $persona->id;
            $cliente->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

        
        
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();

            //Buscar primero el proveedor a modificar
            $cliente = ClienteVenta::findOrFail($request->id);

            $persona = Persona::findOrFail($cliente->id);

            $persona->nombre = $request->nombre;
           $persona->save();
            
            $cliente->phone = $request->phone;
            $cliente->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }
}
