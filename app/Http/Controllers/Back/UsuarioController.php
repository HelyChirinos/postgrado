<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Userlog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Password;
use Yajra\DataTables\Facades\DataTables;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $Usuarios = Usuario::with('userlogs')->withCount('userlogs')->get();

            return DataTables::of($Usuarios)
                ->only([
                    'id',
                    'nombre',
                    'apellido',
                    'cedula',
                    'email',
                    'is_propietario',
                    'telefono',
                    'fecha_nac',
                    'userlogs_count',
                ])
                ->addColumn('DT_RowId', function ($row) {
                    return $row->id;
                })
                ->toJson();
        }

        return view('back.Usuarios.index');
    }

    public function create()
    {
        return view('back.usuarios.modal_create');
    }

    public function store(Request $request)
    {   
        $request['password']=Hash::make($request->cedula);
        $usuario=Usuario::create($request->all());
        $notification = [
            'type' => 'success',
            'title' => 'Agregado ...',
            'message' => 'Usuario agregado.',
        ];

        return redirect()->route('back.usuarios.index')->with('notification', $notification);
    }

    public function edit(Usuario $usuario)
    {

        return view('back.usuarios.modal_update', compact('usuario'));
    }

    public function update( Request $request, Usuario $usuario)
    {
        
            $usuario->update($request->except(['token']));
            $notification = [
                'type' => 'success',
                'title' => 'Editar Usuario ...',
                'message' => 'Usuario Actualizado.',
            ];
        
        return redirect()->route('back.usuarios.index')->with('notification', $notification);
    }




    public function getUserlogs(Request $request)
    {
        $usuariologs_by_date = Userlog::where('user_id', $request->id)
            ->select('userlogs.created_at')
            ->where('created_at', '>=', carbon::now()->startOfMonth()->subMonths(3))
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('date');

        return view('back.usuarios.get-userlogs', compact('userlogs_by_date'))->render();
    }



}
