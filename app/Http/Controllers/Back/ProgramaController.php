<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programa;
use App\Models\Mencion;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Cohorte;
use Illuminate\Support\Facades\Auth;


class ProgramaController extends Controller
{

    
    public function index(Request $request)
    {
        return view('back.tablas.index');
    }

  // =================================================================//
  // =================================================================//  
      
    public function programas(Request $request)
    {
        if ($request->ajax()) {
            $programas = Programa::select('*')->orderBy('programa','ASC')->get();

            return DataTables::of($programas)
                ->only([
                    'id',
                    'programa',
                    'created_at',
                ])
                ->addColumn('DT_RowId', function ($row) {
                    return $row->id;
                })
                ->toJson();
        }

 
    }
    
  // =================================================================//
  // =================================================================//  
  
    public function programa_create()
    {
        return view('back.tablas.programa_modal_create');
    }
  // =================================================================//
   // =================================================================//  
  
    public function programa_store(Request $request)
    {
        $decanato = getSetup();
        $programa = Programa::create([
            'programa' => strtoupper($request->nombre),
            'cod_dec' => $decanato->cod_dec,              
   
        ]);

        Mencion::create([
            'mencion' =>'UNICA',
            'programa_id' => $programa->id,
            'cod_dec' => $decanato->cod_dec,              
        ]);

   
        $notification = [
            'type' => 'success',
            'title' => 'Agregado ...',
            'message' => 'Programa Agregado.',
        ];

        return redirect()->route('back.tablas.index')->with('notification', $notification);
    }

   // =================================================================//
   // =================================================================//  
     
    public function programa_edit(Programa $programa)
    {

        return view('back.tablas.programa_modal_update', compact('programa'));
    }

   // =================================================================//
   // =================================================================//  
      public function programa_update(Request $request, Programa $programa)
    {

            $programa->update([
                'programa' => strtoupper($request->nombre),              

            ]);

            $notification = [
                'type' => 'success',
                'title' => 'Actualizar ...',
                'message' => 'Programa se actualizo....',
            ];
        return redirect()->route('back.tablas.index')->with('notification', $notification);
    }

    // =================================================================//
    // =================================================================//  
    public function programaDestroy(Request $request)
    {

        Programa::whereIn('id', $request->ids)->delete();
        Mencion::whereIn('programa_id', $request->ids)->delete();
        return response()->noContent();
    }
  // =================================================================//
  //                    MENCIONES
  // =================================================================//  
    public function menciones(Request $request)
    {

        if ($request->ajax()) {
            $programas = Programa::with('menciones')->orderBy('programa')->get();
            $a_programas=[];
            foreach ($programas as $programa) {
                foreach ($programa->menciones as $mencion) 
                {
                    array_push($a_programas, (object)[
                        'id' => $mencion->id,
                        'programa' => $programa->programa,
                        'mencion' => $mencion->mencion,
                        'fecha' => $mencion->created_at->toDateString() ,
                    ]);
                }
    
            }
            return DataTables::of($a_programas)
                ->addColumn('DT_RowId', function ($row) {
                    return $row->id;
                })
                ->toJson();
        }

       dd('Error: Llamar Técnico');
    }
    
  // =================================================================//
  // =================================================================//  
  
  public function mencion_create()
  {
      $programas = Programa:: orderBy('programa')->get();  
      return view('back.tablas.mencion_modal_create', compact('programas'));
  }
// =================================================================//
 // =================================================================//  

  public function mencion_store(Request $request)
  {
        $decanato = getSetup();
        $programa = Mencion::create([
            'programa_id'=>$request->programa,  
            'cod_dec' => $decanato->cod_dec,              
            'mencion' => strtoupper($request->mencion), 

        ]);
        

        $notification = [
            'type' => 'success',
            'title' => 'Agregado ...',
            'message' => 'Mención Agregada.',
        ];

        return redirect()->route('back.tablas.index')->with('notification', $notification);
  }

 // =================================================================//
 // =================================================================//  
   
  public function mencion_edit(Mencion $mencion)
  {
     $programas = Programa:: orderBy('programa')->get();
      return view('back.tablas.mencion_modal_update', compact(['programas','mencion']));
  }

 // =================================================================//
 // =================================================================//  
    public function mencion_update(Request $request, Mencion $mencion)
  {

          $mencion->update([
                'programa_id'=>$request->programa,   
                'mencion' => strtoupper($request->mencion),              

          ]);

          $notification = [
              'type' => 'success',
              'title' => 'Actualizar ...',
              'message' => 'La Mención se actualizo....',
          ];
      return redirect()->route('back.tablas.index')->with('notification', $notification);
  }

  // =================================================================//
  // =================================================================//  

  public function mencionDestroy(Request $request)
  {

      Mencion::whereIn('id', $request->ids)->delete();

      return response()->noContent();
  }
// =================================================================//
// =================================================================//  

public function cohortes(Request $request)
{
    if ($request->ajax()) {
        $cohortes = Cohorte::select('*')->orderBy('cohorte','DESC')->get();

        return DataTables::of($cohortes)
            ->addColumn('DT_RowId', function ($row) {
                return $row->id;
            })
            ->toJson();
    }


}

// =================================================================//
  // =================================================================//  
  
  public function cohorte_create()
  {

      return view('back.tablas.cohorte_modal_create');
  }
// =================================================================//
 // =================================================================//  

  public function cohorte_store(Request $request)
  {
      $programa = Cohorte::create([
           'cohorte'=>$request->cohorte,  
           'modalidad' => strtoupper($request->modalidad),  
           'inicio'=>$request->inicio,  
           'termino'=>$request->termino,  

        ]);
      

      $notification = [
          'type' => 'success',
          'title' => 'Agregado ...',
          'message' => 'Cohorte Agregado.',
      ];

      return redirect()->route('back.tablas.index')->with('notification', $notification);
  }

 // =================================================================//
 // =================================================================//  
   
  public function cohorte_edit(Cohorte $cohorte)
  {
      return view('back.tablas.cohorte_modal_update',compact(['cohorte']));
  }

 // =================================================================//
 // =================================================================//  
    public function cohorte_update(Request $request, Cohorte $cohorte)
  {

          $cohorte->update([
               'cohorte' => strtoupper($request->cohorte),              
               'modalidad' => strtoupper($request->modalidad),  
               'inicio'=>$request->inicio,  
               'termino'=>$request->termino,  
          ]);

          $notification = [
              'type' => 'success',
              'title' => 'Actualizar ...',
              'message' => 'La Mención se actualizo....',
          ];
      return redirect()->route('back.tablas.index')->with('notification', $notification);
  }

  // =================================================================//
  // =================================================================//  

  public function cohorteDestroy(Request $request)
  {

      Cohorte::whereIn('id', $request->ids)->delete();

      return response()->noContent();
  }
// =================================================================//
// =================================================================//  






  // =================================================================//  
  
}
