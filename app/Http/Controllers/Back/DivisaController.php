<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Divisa;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
class DivisaController extends Controller
{
    /************************************************************************/
    /* INDEX */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $a_divisas = Divisa::orderBy('fecha')->get()->toArray();
            $cont = 0;
            $valor_dolar_ayer = 0;
            $valor_euro_ayer = 0;
      
            foreach ($a_divisas as &$divisa) {
                if ($cont == 0) {
                    $divisa["variacion_dolar"] = number_format($cont,2);
                    $divisa["variacion_euro"] = number_format($cont,2);
     
                } else {
                    $divisa["variacion_dolar"] = (($divisa["dolar"] == 0) or ($valor_dolar_ayer == 0)  ) ? 0 : number_format((($divisa["dolar"]-$valor_dolar_ayer)/$valor_dolar_ayer)*100,2);
                    $divisa["variacion_euro"] = ( ($divisa["euro"] == 0 ) or ($valor_euro_ayer == 0) ) ? 0 : number_format((($divisa["euro"]-$valor_euro_ayer)/$valor_euro_ayer)*100,2);
    
                }  
                $valor_dolar_ayer = $divisa['dolar']; 
                $valor_euro_ayer = $divisa['euro']; 
                $cont++;
            }
            return DataTables::of($a_divisas)
                ->only([
                    'id',
                    'fecha',
                    'dolar',
                    'euro',
                    'variacion_dolar',
                    'variacion_euro',
                ])
                ->toJson();

        }

        return view('back.divisas.index');
    }

  /************************************************************************/
  /* CREATE */

    public function create()
    {
        return view('back.divisas.modal_create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'fecha' => ['required', 'date', 'unique:credentials.divisas'],
            'dolar' => ['required'],
            'euro' => ['required'],

        ]);

        Divisa::create([
            'fecha' => $request->fecha,              
            'dolar'=> convertMoney($request->dolar),
            'euro'=> convertMoney($request->euro),
        ]);

        $notification = [
            'type' => 'success',
            'title' => 'Agregado ...',
            'message' => 'Divisas Agregadas.',
        ];

        return response()->json(['success' => true]);
        // return redirect()->route('back.divisas.index')->with('notification', $notification);
    }
 
    /************************************************************************/
     /* EDIT */

    public function edit(Divisa $divisa)
    {
        return view('back.divisas.modal_update', compact('divisa'));
    }

   /************************************************************************/
   /* UPDATE */
    public function update(Request $request, Divisa $divisa)
    {

        $validatedData = $request->validate([
            'fecha' =>['required', 'date', Rule::unique('credentials.divisas', 'fecha')->ignore($divisa->id)],
            'dolar' => ['required'],
            'euro' => ['required'],
        ]);
        $divisa->update([
            'fecha' => $request->fecha,              
            'dolar'=> convertMoney($request->dolar),
            'euro'=> convertMoney($request->euro),
        ]);

        $notification = [
            'type' => 'success',
            'title' => 'Actualizar ...',
            'message' => 'Dolar Actualizado.',
        ];

        return response()->json(['success' => true]);
        // return redirect()->route('back.divisas.index')->with('notification', $notification);
    }
   /************************************************************************/
    /* REFRESH DATA */

    public function refresh_data()
    {
        $dolar = cargar_divisa();
        session(['DOLAR' => $dolar]);
        return redirect()->route('back.divisas.index');
    }
 
   /************************************************************************/
    /* DELETE */
    public function massDestroy(Request $request)
    {

        Divisa::whereIn('id', $request->ids)->delete();

        return response()->noContent();
    }

   /************************************************************************/
   /* MESSAGE */

    public function showMessage(Request $request)
    {
    
        if (trim($request->message)=='Nuevo') {
            $notification = [
                'type' => 'success',
                'title' => 'Divisas BCV Agregadas ...',
                'message' => 'Se agrego nuevas Divisas a Tasa BCV.',
            ];
        }
        if (trim($request->message)=='Actualizar') {
            $notification = [
                'type' => 'success',
                'title' => 'Bien Hecho ...',
                'message' => 'Divisas Actualizadas.',
            ];
        }

        return redirect()->route('back.divisas.index')->with('notification', $notification);

    }




}
