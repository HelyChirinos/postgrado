<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Programa;
use App\Models\Mencion;
use App\Models\Recibo;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $estudiantes=Estudiante::with(['programa:id,programa','mencion:id,mencion'])->orderBy('apellidos')->get();
        $a_estud=[];
        foreach ($estudiantes as $estudiante) {
            array_push($a_estud, (object)[
                'id' => $estudiante->id,
                'tipo_doc' => $estudiante->tipo_doc,
                'no_doc'=>$estudiante->no_doc,
                'nombres'=>$estudiante->nombres,
                'apellidos'=>$estudiante->apellidos,
                'programa' => $estudiante->programa->programa,
                'mencion' => $estudiante->mencion->mencion,
                'cohorte' => $estudiante->cohorte,
                'email'=> $estudiante->email,              
                'telefono' => $estudiante->telefono ,

            ]);
        }    
        if ($request->ajax()) {
            return DataTables::of($a_estud)
                ->toJson();

        }

        return view('back.estudiantes.index');


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programas = Programa:: orderBy('programa')->get();
        return view('back.estudiantes.modal_create',compact('programas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
       $validator = Validator::make($request->all(), [
        'tipo_doc' => 'required',
        'no_doc' => 'required|string|max:30|unique:estudiantes',
        'nombres' => 'required|string|max:101',
        'apellidos' => 'required|string|max:101',
        'programa' => 'required|numeric',
        'mencion' => 'required|numeric',
        'email' => 'nullable|email|unique:estudiantes',
        'telefono' => 'nullable|string|max:100', 
        'direccion' => 'nullable|string',
        'cohorte' => 'nullable|string|max:10|exists:cohortes'

    ])->validate();
     
     /* colocar cohorte required cuando se validate */
        
        $decanato = getSetup();
        $estudiante = Estudiante::create([
            'tipo_doc' => $request->tipo_doc,  
            'no_doc' => $request->no_doc,
            'cod_dec' => $decanato->cod_dec,              
            'nombres'=> $request->nombres,
            'apellidos'=> $request->apellidos,
            'programa_id' => $request->programa,  
            'mencion_id' => $request->mencion,              
            'email'=> $request->email,
            'telefono' => $request->telefono,  
            'direccion' => $request->direccion,            
            'cohorte' => $request->cohorte,
            'status' =>'Activo',              
        ]);

        $notification = [
            'type' => 'success',
            'title' => 'Agregado ...',
            'message' => 'Estudiante agregado.',
        ];

        return response()->json(['id' => $estudiante->id]);

        // if($request->ruta=='recibo'){
        //     return redirect()->route('back.recibos.create', [$estudiante])->with('notification', $notification);
        // } else{
        //     return view('back.estudiantes.index')->with('notification', $notification);
        // } 
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudiante $estudiante)
    {
        $programas = Programa:: orderBy('programa')->get();
        $tmp_menciones = Mencion::where('programa_id',$estudiante->programa_id)->orderBy('mencion')->get();
        return view('back.estudiantes.modal_update',compact(['programas','estudiante','tmp_menciones']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estudiante $estudiante)
    {
        
        $validator = Validator::make($request->all(), [
            'tipo_doc' => 'required',
            'no_doc' => ['required', 'string', 'max:30', Rule::unique('estudiantes', 'no_doc')->ignore($estudiante->id)],
            'nombres' => 'required|string|max:101',
            'apellidos' => 'required|string|max:101',
            'programa' => 'required|numeric',
            'mencion' => 'required|numeric',
            'email' => ['nullable' ,'email', Rule::unique('estudiantes', 'email')->ignore($estudiante->id)],
            'telefono' => 'nullable|string|max:100', 
            'direccion' => 'nullable|string',
            'cohorte' => 'nullable|string|max:10|exists:cohortes'            
    
        ])->validate();
     
        $ci_anterior=$estudiante->no_doc; 
        $estudiante->update([
            'tipo_doc' => $request->tipo_doc,  
            'no_doc' => $request->no_doc,              
            'nombres'=> $request->nombres,
            'apellidos'=> $request->apellidos,
            'programa_id' => $request->programa,  
            'mencion_id' => $request->mencion,              
            'email'=> $request->email,
            'telefono' => $request->telefono,  
            'direccion' => $request->direccion,     
            'cohorte' => $request->cohorte     
                     
        ]);
        $estudiante->save();

        if($request->no_doc != $ci_anterior){
                Recibo::where('no_doc',$ci_anterior)->update(['no_doc'=>$request->no_doc]);
        }
  
        $notification = [
            'type' => 'success',
            'title' => 'Actualizado ...',
            'message' => 'Estudiante actualizado.',
        ];

        return redirect()->route('back.estudiantes.index')->with('notification', $notification);
    }

     /**
     * Delete .
     */

     public function estudiantesDestroy(Request $request)
     {
 
         Estudiante::whereIn('id', $request->ids)->delete();
 
         return response()->noContent();
     }


     public function showMessage(Request $request)
     {
     
         if (trim($request->message)=='Nuevo') {
             $notification = [
                 'type' => 'success',
                 'title' => 'Nuevo Estudiante Agregado ...',
                 'message' => 'Se agrego ub Nuevo Estudiante.',
             ];
         }
         if (trim($request->message)=='Actualizar') {
             $notification = [
                 'type' => 'success',
                 'title' => 'Bien Hecho ...',
                 'message' => 'El Estudiante se Actualizo.',
             ];
         }
 
         return redirect()->route('back.estudiantes.index')->with('notification', $notification);
 
     }

     public function showRecibos(Estudiante $estudiante)
     {
     
   
     
        return view('back.estudiantes.consulta_recibos',compact('estudiante'));
 
     }



 
      /**
     * DropDown .
     */

     public function DropDown(Request $request)
     {
      $menciones = Mencion::where('programa_id',$request->programa_id)->orderBy('mencion')->get();

         return $menciones;
     }


}
