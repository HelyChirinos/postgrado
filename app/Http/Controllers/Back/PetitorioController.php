<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Donativo;
use App\Models\Petitorio;
use App\Models\Tmp_deposito;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class PetitorioController extends Controller
{
       /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $monto_donativos = Donativo::select('monto')->get();
        $monto_petitorios = Petitorio::select('monto')->where('status','APROBADO')->orWhere('status','USADO')->get();
        $tot_donativos = $monto_donativos->sum('monto');
        $tot_petitorios = $monto_petitorios->sum('monto');
        $total = round($tot_donativos-$tot_petitorios,2);

        if ($request->ajax()) {
            $a_petitorios=[];
            $petitorios=Petitorio::orderBy('codigo','desc')->get();
            foreach ($petitorios as $item) {
                array_push($a_petitorios, (object)[
                    'id' => $item->id,
                    'codigo'=>$item->codigo,
                    'no_doc' => $item->estudiante->no_doc,
                    'nombre' => $item->estudiante->nombre,
                    'fecha' => $item->fecha,
                    'monto'=>  $item->monto,
                    'status'=> $item->status,
                ]);
            }           
            return DataTables::of($a_petitorios)
                ->toJson();

        }

        return view('back.petitorios.index', compact(['total','tot_donativos','tot_petitorios']));
    }


    public function donativos(Request $request)
    {
        if ($request->ajax()) {
            $a_donativos=[];
            $donativos=Donativo::orderBy('id','desc')->get();
            foreach ($donativos as $item) {
                array_push($a_donativos, (object)[
                    'id' => $item->id,
                    'no_doc' => $item->estudiante->no_doc,
                    'nombre' => $item->estudiante->nombre,
                    'recibo' => $item->recibo->no_recibo,
                    'fecha' => $item->fecha,
                    'monto'=>  $item->monto,

                ]);
            }           
            return DataTables::of($a_donativos)
                ->toJson();

        }      

        return view('back.petitorios.index');

    }

    public function accion(Request $request)
    {
        $petitorio = Petitorio::find($request->id);
        if($petitorio)  {
            $petitorio->update([
                'status' => $request->accion,              
            ]);
        }
        if ($request->accion=='APROBADO'){
            Tmp_deposito::create([
                'tmp_recibo_id'=>$petitorio->tmp_recibo_id,  
                'no_deposito' => $petitorio->codigo,  
                'fecha' => $petitorio->fecha,  
                'monto' => $petitorio->monto,
           ]);                

        }

        return response()->noContent();

    }

}
