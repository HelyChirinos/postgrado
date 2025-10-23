<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Userlog;
use App\Models\Decanato;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Password;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('userlogs')->withCount('userlogs')->with('decanato')->get();
            $a_users=[];
            foreach ($users as $user) {
                $rols=$user->getRoleNames()->toArray();
                array_push($a_users, (object)[
                    'id' => $user->id,
                    'decanato' => $user->decanato->decanato,
                    'nombre'=>$user->nombre,
                    'apellido'=>$user->apellido,
                    'cedula' => $user->cedula,
                    'email'=> $user->email,
                    'roles'=> $rols,              
                    'userlogs_count'=>$user->userlogs_count,
                ]);
     
            }
            return DataTables::of($a_users)
                ->addColumn('DT_RowId', function ($row) {
                    return $row->id;
                })
                ->toJson();
        }
        
        return view('back.users.index');
    }

    public function create()
    {   
        $decanatos=Decanato::all();
        $roles= Role::all();

        //       PROBANDO PARA VISTA EN VEZ DE MODAL ////
        $modulos = ['Divisas', 'Recibos','Estudiantes','Aranceles','Matrículas','Programas',
        'Cohortes','Bancos','Reportes'];
        $permisos = Permission::get();

        return view('back.users.create',compact('decanatos','roles','modulos','permisos'));

        // ----------------------------------------------------------//

       // return view('back.users.modal_create',compact('decanatos','roles'));

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => ['required', 'string', 'max:101'],
            'apellido' => ['required', 'string', 'max:101'],
            'cedula' => ['required', 'string', 'max:101', 'unique:credentials.users'],
            'email' => ['required', 'string', 'max:191', 'email', 'unique:credentials.users'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'same:password_confirmation'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:255'],
            'cod_dec' => ['required', 'string', 'max:2'], 
            'telefono' => ['nullable', 'string', 'max:101'], 
        ]);
     
        $user = User::create($validatedData);
        Password::sendResetLink($request->only(['email']));
         if ($request->input('roles')) {
            $roles = json_decode(stripslashes($request->roles));
            $user->assignRole($roles);
         } else {
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
            $user->givePermissionTo($permisos);
         }   

     
        $notification = [
            'type' => 'success',
            'title' => 'Agregado ...',
            'message' => 'El usuario se agregó.',
        ];

        return redirect()->route('back.users.index')->with('notification', $notification);


//        return response()->json(['success' => true]);

    }

    public function edit(User $user)
    {        
        $roles= Role::all();
        $decanatos=Decanato::all();
        $userRoles= $user->getRoleNames()->toArray();
        $modulos = ['Divisas', 'Recibos','Estudiantes','Aranceles','Matrículas','Programas',
        'Cohortes','Bancos','Reportes'];
        $permisos = Permission::get();
        $user_permisos = $user->permissions->pluck('name')->toArray();

        return view('back.users.edit', compact('user','decanatos','roles','userRoles','permisos','user_permisos','modulos'));
    }

    public function update(Request $request, User $user)
    {
    
        $validatedData = $request->validate([
            'nombre' => ['required', 'string', 'max:101'],
            'apellido' => ['required', 'string', 'max:101'],
            'cod_dec' => ['required', 'string', 'max:2'], 
            'cedula' => ['required', 'string', 'max:101', Rule::unique('credentials.users', 'cedula')->ignore($user->id)],
            'email' => ['required', 'string', 'max:191', 'email', Rule::unique('credentials.users', 'email')->ignore($user->id)],
            'fecha_nac' => ['nullable', 'date', 'max:101'], 
            'telefono' => ['nullable', 'string', 'max:101'], 
        ]);
     
        $user->update($request->except(['token']));
        $roles = json_decode($request->roles);
        if (($request->input('roles')) && (!empty($roles)) ) {
            if(is_null($roles)) {
                $roles=[];
                array_push($roles,$request->roles);
            }
            $user->syncRoles($roles);
            $permiso_user=[];
            $user->syncPermissions($permiso_user);
        } else {
            $sinRol=[];
            $user->syncRoles($sinRol);
            $user->syncPermissions($request->permisos);

        }    
        $notification = [
                'type' => 'success',
                'title' => 'Editado ...',
                'message' => 'Usuario Actualizado.',
            ];
      return redirect()->route('back.users.index')->with('notification', $notification);
       
    }

    public function massDestroy(Request $request)
    {
        User::where('id', '>', 2)->whereIn('id', $request->ids)->delete();

        return response()->noContent();
    }

    public function getUserlogs(Request $request)
    {
        $date = Carbon::now();

        $userlogs_by_date = Userlog::where('user_id', $request->id)
            ->select('userlogs.created_at')
            ->where('created_at', '>=', $date->startOfMonth()->subMonths(3)->format('Y-m-d'))
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('date');

        return view('back.users.get-userlogs', compact('userlogs_by_date'))->render();
    }


    public function showMessage(Request $request)
    {
    
        if (trim($request->message)=='Nuevo') {
            $notification = [
                'type' => 'success',
                'title' => 'Excelente ...',
                'message' => 'Nuevo usuario agregado.',
            ];
        }
        if (trim($request->message)=='Actualizar') {
            $notification = [
                'type' => 'success',
                'title' => 'Bien Hecho ...',
                'message' => 'Usuario Actualizado.',
            ];
        }

        return redirect()->route('back.users.index')->with('notification', $notification);

    }

    public function add_question(Request $request)
    {
        return $request->all();
    }
}
