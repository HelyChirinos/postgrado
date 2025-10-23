<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

 // PRUEBAS
 Route::get('/pruebas', [App\Http\Controllers\PruebasController::class,'exportar']);
 Route::get('/rollback', [App\Http\Controllers\PruebasController::class,'cierre_rollback']);

// Home
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// storage links y path servidor produccion
// ------------------------------------------------------------------

Route::get('path', function(){
    echo ('PATH REAL:  '.realpath(base_path('/../html/sistema')));
    echo('<br>');echo('<br>');
    echo('PUBLIC PATH: '.public_path());
    echo('<br>');echo('<br>');
    echo('BASE PATH: '.base_path());
    echo('<br>');echo('<br>');
    echo('STORAGE PATH: '.storage_path());
 });
           /// este es el que funciona: Realiza el storage:link//
Route::get('symlink', function(){
    $storageFolder = storage_path().'/app/public';
    $linkFolder = public_path().'/storage';
    symlink($storageFolder,$linkFolder);
    echo 'se complento el storage:link utilizando el Symlink';
});

 // Localization
 Route::get('locale/{lang}', [App\Http\Controllers\LocaleController::class,'setLocale']);

// Frontend routes
Route::prefix('front')->as('front.')->group(function () {
    // Nothing here yet
});

// Backend routes
Route::prefix('back')->as('back.')->group(function () {
    // USERS
    Route::middleware('auth')->group(function () {
        /* ------------------------------------------------------------------------ */
        // General
        Route::controller(App\Http\Controllers\Back\GeneralController::class)->group(function () {
            Route::post('/general/setValueDB', 'setValueDB')->name('general.setValueDB');
            Route::post('/general/setValueSession', 'setValueSession')->name('general.setValueSession');
            Route::get('/general/getDatatablesHelp', 'getDatatablesHelp')->name('general.getDatatablesHelp');
        });
        /* ---------------------------------------- */
        // Customers
        Route::controller(App\Http\Controllers\Back\CustomerController::class)->group(function () {
            Route::delete('/customers/massDestroy', 'massDestroy')->name('customers.massDestroy');
            Route::get('/customers/getAlikes', 'getAlikes')->name('customers.getAlikes');

            Route::resource('/customers', App\Http\Controllers\Back\CustomerController::class)->except(['destroy']);
        });
        /* ------------------------------------------------------------------------ */
    });

    // DEVELOPER
    Route::middleware('auth')->group(function () 
    {
        /* ------------------------------------------------------------------------ */
        // Developer
        Route::controller(App\Http\Controllers\Back\DeveloperController::class)->group(function () {
            Route::get('/developer/hashGenerator', 'hashGenerator')->name('developer.hashGenerator');
            Route::get('/developer/impressum', 'impressum')->name('developer.impressum');
            Route::get('/developer/session', 'session')->name('developer.session');
            Route::get('/developer/test', 'test')->name('developer.test');
        });
        /* ---------------------------------------- */
        // Backups
        Route::controller(App\Http\Controllers\Back\BackupController::class)->group(function () {
            Route::get('/backups', 'index')->name('backups.index');
            Route::get('/backups/create', 'create')->name('backups.create');
            Route::get('/backups/download/{file_name}', 'download')->name('backups.download');
            Route::get('/backups/delete/{file_name}', 'delete')->name('backups.delete');
        });
        /* ------------------------------------------------------------------------ */
        // Users
        Route::controller(App\Http\Controllers\Back\UserController::class)->group(function () {
            Route::get('/users/getUserlogs', 'getUserlogs')->name('users.getUserlogs');
            Route::delete('/users/massDestroy', 'massDestroy')->name('users.massDestroy');
            Route::get('/users/create', 'create')->name('users.create');
            Route::get('/users/modal', 'showModal')->name('users.modal');
            Route::get('/users/notification/{message} ', 'showMessage')->name('users.message');
            Route::resource('/users', App\Http\Controllers\Back\UserController::class)->except(['show', 'destroy']);
        });

        // Users log
        Route::controller(App\Http\Controllers\Back\UserlogController::class)->group(function () {
            Route::get('/userslog/index', 'index')->name('userslog.index');
            Route::get('/userslog/statsCountry', 'statsCountry')->name('userslog.statsCountry');
            Route::get('/userslog/statsCountryMap', 'statsCountryMap')->name('userslog.statsCountryMap');
            Route::get('/userslog/statsPeriod', 'statsPeriod')->name('userslog.statsPeriod');
        });
        /* ------------------------------------------------------------------------ */
        // Usuarios
        Route::controller(App\Http\Controllers\Back\UsuarioController::class)->group(function () {
            Route::get('/usuarios/getUserlogs', 'getUserlogs')->name('usuarios.getUserlogs');
            Route::resource('/usuarios', App\Http\Controllers\Back\UsuarioController::class)->except(['show', 'destroy']);
        });
        /* ------------------------------------------------------------------------ */
        // Divisas
        Route::controller(App\Http\Controllers\Back\DivisaController::class)->group(function () {
            Route::get('/divisas/refresh', 'refresh_data')->name('divisas.refresh');
            Route::delete('/divisas/massDestroy', 'massDestroy')->name('divisas.massDestroy');
            Route::get('/divisas/notification/{message} ', 'showMessage')->name('divisas.message');
            Route::resource('/divisas', App\Http\Controllers\Back\DivisaController::class)->except(['show', 'destroy']);
        });     
        /* ------------------------------------------------------------------------ */
        // Perfil
        Route::controller(App\Http\Controllers\Back\ProfileController::class)->group(function () {
            Route::get('/profile', 'show')->name('profile.show');
            Route::put('/profile/update/{user}', 'update')->name('profile.update');
            Route::get('/profile/update-password', 'showPassword')->name('profile.showPassword');
            Route::put('/profile/update-password/{user}', 'updatePassword')->name('profile.updatePassword');

        });

        /* ------------------------------------------------------------------------ */
        // Programas y Menciones estan los dos en el mismo controller
        Route::controller(App\Http\Controllers\Back\ProgramaController::class)->group(function () {
            Route::get('/tablas_base', 'index')->name('tablas.index');
            Route::get('/programas', 'programas')->name('programas.datos');
            Route::get('/programas/create', 'programa_create')->name('programas.create');
            Route::post('/programas/store', 'programa_store')->name('programas.store');
            Route::get('/programas/{programa}/edit', 'programa_edit')->name('programas.edit'); 
            Route::put('/programas/{programa}', 'programa_update')->name('programas.update');  
            Route::delete('/programas/massDestroy', 'programaDestroy')->name('programas.Destroy');                      
            Route::get('/menciones', 'menciones')->name('menciones.datos');
            Route::get('/menciones/create', 'mencion_create')->name('menciones.create');
            Route::post('/menciones/store', 'mencion_store')->name('menciones.store');
            Route::get('/menciones/{mencion}/edit', 'mencion_edit')->name('menciones.edit'); 
            Route::put('/menciones/{mencion}', 'mencion_update')->name('menciones.update');  
            Route::delete('/menciones/massDestroy', 'mencionDestroy')->name('menciones.Destroy'); 
            Route::get('/cohortes', 'cohortes')->name('cohortes.datos');  
            Route::get('/cohortes/create', 'cohorte_create')->name('cohortes.create');
            Route::post('/cohortes/store', 'cohorte_store')->name('cohortes.store');
            Route::get('/cohortes/{cohorte}/edit', 'cohorte_edit')->name('cohortes.edit'); 
            Route::put('/cohortes/{cohorte}', 'cohorte_update')->name('cohortes.update');  
            Route::delete('/cohortes/massDestroy', 'cohorteDestroy')->name('cohortes.Destroy'); 

        });

        // Aranceles
        Route::controller(App\Http\Controllers\Back\ArancelController::class)->group(function () {
            Route::resource('/aranceles', App\Http\Controllers\Back\ArancelController::class)->except(['show', 'destroy']);
            Route::delete('/aranceles/massDestroy', 'arancelesDestroy')->name('aranceles.Destroy');  
            Route::get('/matriculas', 'matriculas_index')->name('matriculas.index');
            Route::get('/matriculas/create', 'matricula_create')->name('matriculas.create');
            Route::post('/matriculas/store', 'matricula_store')->name('matriculas.store');
            Route::get('/matriculas/{matricula}/edit', 'matricula_edit')->name('matriculas.edit'); 
            Route::put('/matriculas/{matricula}', 'matricula_update')->name('matriculas.update');
            Route::delete('/matriculas/massDestroy', 'matriculasDestroy')->name('matriculas.Destroy'); 
            Route::get('/paginas', 'paginas_index')->name('paginas.index'); 
            Route::get('/paginas/create', 'paginas_create')->name('paginas.create');
            Route::post('/paginas/store', 'paginas_store')->name('paginas.store');
            Route::get('/paginas/{paginas}/edit', 'paginas_edit')->name('paginas.edit'); //CUIDADO CON PARAMETRO pag_programa} 
            Route::put('/paginas/{paginas}', 'paginas_update')->name('paginas.update');
            Route::post('/arancel/setValue', 'setValueDB')->name('arancel.setValueDB');
            Route::delete('/paginas/massDestroy', 'paginasDestroy')->name('paginas.Destroy'); 
        });     
        /* ------------------------------------------------------------------------ */

         // Estudiantes
         Route::controller(App\Http\Controllers\Back\EstudianteController::class)->group(function () {
            Route::resource('/estudiantes', App\Http\Controllers\Back\EstudianteController::class)->except(['show', 'destroy']);
            Route::delete('/estudiantes/massDestroy', 'estudiantesDestroy')->name('estudiantes.Destroy');
            Route::post('/estudiantes/dropdown', 'dropdown')->name('estudiantes.dropdown');
            Route::get('/estudiantes/notification/{message} ', 'showMessage')->name('estudiantes.message');
            Route::get('/estudiantes/recibos/{estudiante} ', 'showRecibos')->name('estudiantes.recibos');

        });     
        /* ------------------------------------------------------------------------ */
        // Recibos
        Route::controller(App\Http\Controllers\Back\ReciboController::class)->group(function () {
            Route::get('/recibos', 'index')->name('recibos.index');
            Route::get('/recibos/create/{estudiante}','create')->name('recibos.create');
            Route::post('/recibos/store/','store')->name('recibos.store');                
            Route::get('/recibos/pdf/{recibo}', 'printRecibo')->name('recibos.Pdf');
            Route::get('/recibos/validaEstudiante','validaEstudiante')->name('recibos.validaEstudiante');
            Route::post('/recibos/ajax_store/','ajax_store')->name('recibos.ajax_store');
            Route::get('/recibos/validaRecibo','validaRecibo')->name('recibos.validaRecibo');  
            Route::get('/recibos/verificado/{tmp_recibo}','showVerificado')->name('recibos.showVerificado');  
            Route::get('/recibos/goBack/{tmp_recibo}','goBack')->name('recibos.goBack');
            Route::get('/recibos/sugerencias','sugerencias')->name('recibos.sugerencias');
            Route::post('/recibos/petitorio','petitorio')->name('recibos.petitorio');
            Route::get('/recibos/validaPetitorio','validaPetitorio')->name('recibos.validaPetitorio');
            Route::delete('/recibos/massDestroy', 'recibosDestroy')->name('recibos.Destroy');
            Route::get('/recibos/consulta/{recibo}','consultaRecibo')->name('recibos.consulta');
            Route::get('/recibos/find_depositos','getDeposito')->name('recibos.getDeposito');
            Route::get('/recibos/lotes','printLote')->name('recibos.lotes');

   
        });    
        /* ------------------------------------------------------------------------ */
      
        // Petitorios
        Route::controller(App\Http\Controllers\Back\PetitorioController::class)->group(function () {
            Route::get('/petitorios/index', 'index')->name('petitorios.index');
            Route::post('/petitorios/accion', 'accion')->name('petitorios.accion');
            Route::get('/petitorios/donativos', 'donativos')->name('petitorios.donativos');
        });
      /* ------------------------------------------------------------------------ */
      
        // Conciliación Bancaria
        Route::controller(App\Http\Controllers\Back\BancoController::class)->group(function () {
            Route::get('/bancos', 'index')->name('bancos.index');
            Route::post('/bancos/import', 'importFile')->name('bancos.import');
            Route::get('/bancos/upload', 'upload')->name('bancos.upload');
            Route::get('/bancos/conciliacion', 'conciliacion')->name('bancos.conciliacion');
            Route::get('/bancos/ajax_cierre', 'ajax_cierre')->name('bancos.ajax_cierre');
            Route::get('/bancos/ajax_diario', 'ajax_diario')->name('bancos.ajax_diario');
            Route::get('/bancos/diario', 'index_diario')->name('bancos.index_diario');
            Route::get('/bancos/uploadDiario', 'uploadDiario')->name('bancos.uploadDiario');
            Route::post('/bancos/importDiario', 'importDiario')->name('bancos.importDiario');
            Route::get('/bancos/resumen', 'resumen')->name('bancos.resumen');
            Route::get('/bancos/showExcel', 'excelResumen')->name('bancos.showExcel');
            Route::get('/bancos/showPDF', 'pdfResumen')->name('bancos.showPdf');


        });

        /* ------------------------------------------------------------------------ */
      
        // Reportes
        Route::controller(App\Http\Controllers\Back\ReportsController::class)->group(function () {
            Route::get('/reportes', 'index')->name('reportes.index');
            Route::get('/reportes/prueba', 'prueba')->name('reportes.prueba');
            Route::get('/reportes/recibos', 'repo_recibos_mes')->name('reportes.recibos.mes');
            Route::get('/pdf/recibos', 'pdf_recibos_mes')->name('pdf.recibos.mes');
            Route::get('/reportes/recibos_completo', 'repo_recibos_completo')->name('reportes.recibos_completo');
            Route::get('/pdf/recibos_completo', 'pdf_recibos_completo')->name('pdf.recibos_completo');
            Route::get('/reportes/recibos_periodo', 'repo_recibos_periodo')->name('reportes.recibos.periodo');
            Route::get('/pdf/recibos_periodo', 'pdf_recibos_periodo')->name('pdf.recibos.periodo');
            Route::get('/reportes/recibos_completo_periodo', 'repo_recibos_completo_periodo')->name('reportes.recibos_completo_periodo');
            Route::get('/pdf/recibos_completo_periodo', 'pdf_recibos_completo_periodo')->name('pdf.recibos_completo_periodo');
            Route::get('/reportes/recibos_aranceles_mes', 'repo_recibos_arancel')->name('reportes.recibos_aranceles');
            Route::get('/reportes/recibos_constacias_mes', 'repo_recibos_constancias')->name('reportes.recibos_constancias');
            Route::get('/reportes/constancias_mes', 'repo_constancias_mes')->name('reportes.constancias_mes');
            Route::get('/pdf/recibos_aranceles_mes', 'pdf_aranceles_mes')->name('pdf.aranceles_mes');
            Route::get('/reportes/recibos_aranceles_periodo', 'repo_recibos_arancel_periodo')->name('reportes.aranceles_periodo');
            Route::get('/pdf/recibos_aranceles_periodo', 'pdf_aranceles_periodo')->name('pdf.aranceles_periodo');
            Route::get('/reportes/recibos_matriculas_mes', 'repo_recibos_matricula')->name('reportes.recibos_matriculas');
            Route::get('/pdf/recibos_matricula_mes', 'pdf_matricula_mes')->name('pdf.matricula_mes');
            Route::get('/reportes/recibos_matriculas_periodo', 'repo_recibos_matricula_periodo')->name('reportes.matriculas_periodo');
            Route::get('/pdf/matriculas_periodo', 'pdf_matriculas_periodo')->name('pdf.matriculas_periodo');
            Route::get('/excel/fullRecibos', 'ExcelFullRecibos')->name('excel.FullRecibos');
            Route::get('/reportes/resumen/mes', 'resumen_mes')->name('reportes.resumen.mes');
            Route::get('/excel/constancias/mes', 'excel_constancias_mes')->name('excel.constancias.mes');
            

  
        });
      /* ------------------------------------------------------------------------ */

        // videos
        Route::controller(App\Http\Controllers\Back\VideoController::class)->group(function () {
            Route::get('/videos', 'index')->name('videos.index');
        });
      /* ------------------------------------------------------------------------ */
        // Roles y Permisos
        Route::controller(App\Http\Controllers\Back\RolController::class)->group(function () {
            Route::get('/roles', 'index')->name('roles.index');
            Route::get('/roles/create', 'create')->name('roles.create');
            Route::post('/roles/store', 'store')->name('roles.store');
            Route::get('/reles/{role}/edit', 'edit')->name('roles.edit'); 
            Route::put('/roles/{role}/update', 'update')->name('roles.update');  
            Route::delete('/roles/massDestroy', 'massDestroy')->name('roles.massDestroy');

 
        });
      /* ------------------------------------------------------------------------ */


    });


   

});


