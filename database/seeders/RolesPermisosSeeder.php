<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modulos = ['Divisas', 'Recibos','Estudiantes','Aranceles','Matrículas','Programas',
        'Cohortes','Bancos','Reportes'];
        $acciones = ['Ver ', 'Agregar ', 'Modificar ', 'Eliminar '];
         DB::table('roles')->delete();
         DB::table('permissions')->delete();
         DB::statement("ALTER TABLE roles AUTO_INCREMENT =  1");
         DB::statement("ALTER TABLE permissions AUTO_INCREMENT =  1");
        
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        foreach ($modulos as $modulo) {
            if ($modulo=='Reportes') {
                $permission = Permission::create(['name' => 'Ver Reportes','modulo' => 'Reportes']);

            } else {
                if ($modulo=='Recibos') {
                    $permission = Permission::create(['name' => 'Ver Recibos','modulo' => $modulo]);
                    $permission = Permission::create(['name' => 'Agregar Recibos','modulo' => $modulo]);
                    $permission = Permission::create(['name' => 'Anular Recibos','modulo' => $modulo]);

                } else {
                    if ($modulo=='Bancos') {
                        $permission = Permission::create(['name' => 'Ver Bancos','modulo' => $modulo]);
                        $permission = Permission::create(['name' => 'Subir Diario','modulo' => $modulo]);
                        $permission = Permission::create(['name' => 'Subir Cierre','modulo' => $modulo]);
                        $permission = Permission::create(['name' => 'Permitir Conciliación','modulo' => $modulo]);

                    } else {

                        foreach ($acciones as $accion) {
                            $nombre = $accion.$modulo;
                            $permission = Permission::create(['name' => $nombre,'modulo' => $modulo]);
                        }
                    }    

                }
            }
            
        }
        $role = Role::create(['name' => 'SuperAdmin','description'=>'Para Usuarios con todos los privilegios y permisos además de poder acceder a todos los Decanatos' ]);
        $role->givePermissionTo(Permission::all());
        $role = Role::create(['name' => 'Administrador','description'=>'Los mismmos privilegios del SuperAdmin excepto - Administración de Usuarios -' ]);
        $role->givePermissionTo(Permission::all());
        $role = Role::create(['name' => 'Invitado','description'=>'Sin Permisos. Solo Ingreso al Sistema' ]);
        $role->givePermissionTo('Ver Divisas');
        $users = User::all();
        foreach ($users as $user) {
            if (($user->cedula=='15886378') || ($user->cedula=='7222809')) {
                $user->assignRole('SuperAdmin');
            } else {
                $user->assignRole('Administrador');
            }
        }
    }
}
