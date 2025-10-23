<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{

    /************************************************************************/
    /* INDEX */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::get();
            $a_rol=[];
            foreach ($roles as $rol) {
                if (($rol-> name=='SuperAdmin') || ($rol->name =='Administrador')) {
                    $rol_permisos=['Todos'];
                } else {
                    $rol_permisos=[];
                    $rol_permisos=implode("-",$rol->permissions->pluck('name')->toArray()); 
                }
                array_push($a_rol, (object)[
                    'id'=>$rol->id,
                    'name' => $rol->name,
                    'description' =>$rol->description,
                    'permisos' => $rol_permisos,
                    'created_at' =>date($rol->created_at),
                ]);
        }
            return DataTables::of($a_rol)
                ->toJson();

        }
        return view('back.roles.index');
    }

  /************************************************************************/
  /* CREATE */

    public function create()
    {
   
        $modulos = ['Divisas', 'Recibos','Estudiantes','Aranceles','Matrículas','Programas',
        'Cohortes','Bancos','Reportes'];
        $permisos = Permission::get();
        return view('back.roles.modal_create', compact(['permisos','modulos']));

    }

    public function store(Request $request)
    {
        if($request->has('permisos') ){
            if (!in_array("Ver Divisas", $request->permisos))
            { 
                $permisos = $request->permisos;
                array_unshift($permisos,"Ver Divisas");
            } else {
                $permisos = $request->permisos;
            }
        } else {
           $permisos = ['Ver Divisas']; 
        }
        $role = Role::create(['name' => $request->name,'description'=>$request->descripcion ]);
        $role->syncPermissions($permisos);        
        $notification = [
            'type' => 'success',
            'title' => 'Agregado ...',
            'message' => 'El Rol se Agrego correctamente.',
        ];

         return redirect()->route('back.roles.index')->with('notification', $notification);
    }
 
    /************************************************************************/
     /* EDIT */



     public function edit(Role $role)
    {
        $permisos_rol = $role->permissions->pluck('id')->toArray();
        $permisos_rol = array_map('intval', $permisos_rol);

        $modulos = ['Divisas', 'Recibos','Estudiantes','Aranceles','Matrículas','Programas',
        'Cohortes','Bancos','Reportes'];
        $permisos = Permission::get();
 
        return view('back.roles.modal_update', compact('role','permisos','modulos','permisos_rol'));
    }

  

   /************************************************************************/
   /* UPDATE */
    public function update(Request $request, Role $role)
    {
     
        // $permisos = array_map('intval', $request->permisos);
        // if (!in_array(1, $permisos)) {
        //    array_unshift($permisos,1);
        // } 

        $role->update([
            'name' => $request->name,              
            'description'=> $request->descripcion,
        ]);
        $role->save();
        $role->syncPermissions($request->permisos);
        if (!$role->hasPermissionTo('Ver Divisas')){
            $role->givePermissionTo('Ver Divisas');
        }        
        $notification = [
            'type' => 'success',
            'title' => 'Actualizado ...',
            'message' => 'RoL Actualizado.',
        ];

        return redirect()->route('back.roles.index')->with('notification', $notification);
    }


   /************************************************************************/
    /* DELETE */
    public function massDestroy(Request $request)
    {

        Role::where('id', '>', 2)->whereIn('id', $request->ids)->delete();

        return response()->noContent();
    }

 



}
