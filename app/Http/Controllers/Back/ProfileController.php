<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function Show()
    {
        $user = Auth::user();
        return view('back.profile.profile', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'nombre' => ['required', 'string', 'max:101'],
            'apellido' => ['required', 'string', 'max:101'],
            'cedula' => ['required', 'string', 'max:101', Rule::unique('credentials.users', 'cedula')->ignore($user->id)],
            'email' => ['required', 'string', 'max:191', 'email', Rule::unique('credentials.users', 'email')->ignore($user->id)],
            'fecha_nac' => ['nullable', 'date', 'max:101'], 
            'telefono' => ['nullable', 'string', 'max:101'], 
        ]);
     
       $user->update($validatedData);
        if ($foto = $request->foto) {
            $user->updateProfilePhoto($foto);
        }
 
        $notification = [
            'type' => 'success',
            'title' => 'Correcto ...',
            'message' => 'Su perfil ha sido Actualizado.',
        ];
   
        return redirect()->route('back.profile.show')->with('notification', $notification);
    }

        public function showPassword()
    {
       
        return view('back.profile.update_password');
    }

    public function updatePassword(Request $request, User $user) {
        
        $validatedData = $request->validateWithBag('updatePass', [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => ['required', 'confirmed', 'min:8'],
            [
                'current_password.current_password' => __('Este password no es igual a su password actual.'),
            ]          

        ]);

        $user->update($validatedData);
        return redirect()->route('back.profile.showPassword')->with('mensaje','se actualizo el Password correctamente');    
    }


    
}
