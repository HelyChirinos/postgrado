<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Banco;
use App\Imports\BancoImport;
use App\Imports\DiarioImport;
use App\Models\Deposito;
use App\Models\Estudiante;
use App\Models\Diario;
use Illuminate\Http\Request;
use App\Models\Recibo;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Transito;
use App\Models\Cierre;
use App\Exports\GeneralExport;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;

class BancoController extends Controller
{

    public function index(Request $request) 
    {
        $banco=Banco::get(); 

        if ($banco->count()){
            $temp = Banco::whereNotNull('fecha_operacion')->orderBy('fecha_operacion','asc')->first();
            $desde = formatFecha($temp->fecha_operacion);
            $temp = Banco::whereNotNull('fecha_operacion')->orderBy('fecha_operacion','desc')->first();
            $hasta = formatFecha($temp->fecha_operacion);
            $periodo =' del: '.$desde.' al: '.$hasta;
        }else {
            return redirect()->route('back.bancos.index_diario');
            $periodo =' del: --------  al: --------';
        }
        return view('back.bancos.index', compact(['banco' , 'periodo' ]));
    }


     /**
     * Diario
     */
    public function index_diario(Request $request) 
    {
        $diario=Diario::get(); 
        if ($diario->count()){
            $temp = Diario::whereNotNull('f_operacion')->orderBy('f_operacion','asc')->first();
            $desde = formatFecha($temp->f_operacion);
            $temp = Diario::whereNotNull('f_operacion')->orderBy('f_operacion','desc')->first();
            $hasta = formatFecha($temp->f_operacion);
            $periodo =' del: '.$desde.' al: '.$hasta; 
            foreach ($diario as $deposito) {
                $consignado=Deposito::where('numero',trim($deposito->no_doc))->first();
                if($consignado){
                    $deposito->update(['consignado'=>1]);
                } 
            }
            $diario=Diario::get(); 
               
        }else {

            $periodo =' del: --------  al: --------';
        }
        return view('back.bancos.diario_index', compact(['diario' , 'periodo' ]));
    }

     /**
     * Ajax
     */


    public function ajax_cierre(Request $request) 
    {
        $banco=Banco::get();
        foreach ($banco as $deposito) {
                $consignado=Deposito::where('numero',trim($deposito->referencia))->first();
                if($consignado){
                    $deposito->update(['consignado'=>1]);
                } 
        }
        if ($request->ajax()) {
            
            return DataTables::of($banco)
                ->toJson();
        }
    }

    public function ajax_diario(Request $request) 
    {
        $diario=Diario::get(); 
        foreach ($diario as $deposito) {
                $consignado=Deposito::where('numero',trim($deposito->no_doc))->first();
                if($consignado){
                    $deposito->update(['consignado'=>1]);
                } 
            }
        $diario=Diario::get(); 
        if ($request->ajax()) {

            return DataTables::of($diario)
                ->toJson();
        }
    }
 
     /**
     * Cargar Archivos
     */

 
    public function upload() 
    {
        return view('back.bancos.uploadFile');
    }

     
    public function uploadDiario() 
    {
        return view('back.bancos.uploadDiario');
    }

    /**
     *   Leer Archivos Excel
     */     

    public function importFile(Request $request) 
    {
        Banco::truncate();
        try {
            Excel::import(new BancoImport, request()->file('excel_file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            
            $notification = [
                'type' => 'error',
                'title' => 'Error Archivo!!!',
                'message' => 'NO SE CARGO EL ARCHIVO EXCEL, VERIFIQUE',
            ];
            return back()->with('notification', $notification);
        }
        // Diario::truncate();

        $notification = [
            'type' => 'success',
            'title' => 'TODO BIEN!!!',
            'message' => 'SE CARGO EL ARCHIVO EXCEL',
        ];

        
        return redirect()->route('back.bancos.index')->with('notification', $notification);
    }

    public function temp_conciliacion(Request $request) 
    {
        $temp = Banco::whereNotNull('fecha_operacion')->orderBy('fecha_operacion','desc')->first();
        $f_cierre = $temp->fecha_operacion;
        $banco=Banco::where('abono','<>',0)->where('fecha_operacion','<>',null)->get(); 
        $a_concilia=[];
        $a_transito=[];
        $depositos = Deposito::where('conciliado','!=',1) ->get();
        foreach ($banco as $item) {
           if ($encontrado=$depositos->where('referencia',$item->referencia)->first()){
                $estud = Estudiante::find($encontrado->estudiante_id);
                $recibo = Recibo::find($encontrado->recibo_id);
                array_push($a_concilia, (object)[
                    'referencia'=>$item->referencia,
                    'banco_id' => $item->id,
                    'recibo' => ($recibo) ? $recibo->no_recibo : '----',
                    'no_doc' => $estud->no_doc,                    
                    'nombre' => $estud->nombre,
                    'banco_fecha' =>$item->fecha_operacion,
                    'deposito_fecha'=>$encontrado->fecha,
                    'banco_monto' =>$item->abono,
                    'deposito_monto'=>$encontrado->monto,                
                ]);
 
           } else { 
                array_push($a_transito,$item->id);
            }       
        }


        $transito = Banco::whereIn('id', $a_transito)->get();
        $conciliados = $a_concilia;
        
        return view('back.bancos.showConcilia', compact(['transito','conciliados']));
    }


    public function conciliacion(Request $request) 
    {

        $temp = Banco::whereNotNull('fecha_operacion')->orderBy('fecha_operacion','desc')->first();
        $f_cierre=$temp->fecha_operacion;
        
        $tmp_fecha = Carbon::parse($temp->fecha_operacion);
        $mes = $tmp_fecha->month;
        $ano = $tmp_fecha->year;
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        if ($resumen=Cierre::where('mes',$mes)->where('ano',$ano)->first())
        {
            Banco::truncate();
            return view('back.bancos.conciliado', compact(['resumen','periodo']));
        }
        $a_transito=[];
        $a_conciliado=[];
        $cierre = [];
        $comisiones = Banco::where('descripcion','like','%COMIS%')->get();
        $transferencias = Banco::where('descripcion','not like','%COMIS%')
        ->where('cargo','<>',0)
        ->get();
        $saldo_anterior=Banco::where('descripcion','like','SALDO ANTERIOR')->first();
        $ingresos=Banco::where('abono','>',0)->where('fecha_operacion','<>',null)->get(); 
        $enTransito=Transito::all();
        $depositos = Deposito::where('conciliado','!=',1)->whereDate('fecha','<=',$f_cierre)->get();
        // PRIMERO TRANSITO
        foreach ($enTransito as $transito) {
            if ($encontrado=$depositos->where('referencia',$transito->referencia)->first())
            {
                $estud = Estudiante::find($encontrado->estudiante_id);
                $recibo = Recibo::find($encontrado->recibo_id);
                $encontrado->update([
                    'fec_conciliacion' => $f_cierre,              
                    'conciliado'=> 1,
                ]);
                array_push($a_conciliado, (object)[
                    'referencia'=>$transito->referencia,
                    'banco_id' => $transito->id,
                    'recibo' => ($recibo) ? $recibo->no_recibo : '----',
                    'no_doc' => $estud->no_doc,                    
                    'nombre' => $estud->nombre,
                    'banco_fecha' =>$transito->fecha_operacion,
                    'deposito_fecha'=>$encontrado->fecha,
                    'banco_monto' =>0,
                    'deposito_monto'=>$transito->abono,
                    'monto_otro'=>$encontrado->monto,
                    'transito'=>true,                
                ]);
                // Guardar en Historico antes de eliminar
                DB::table('historico_transitos')->insert([
                    'mes_cierre' => $mes,
                    'ano_cierre' => $ano,
                    'fecha_cierre'=>$f_cierre,
                    'referencia'=>$transito->referencia,
                    'descripcion' => $transito->descripcion,
                    'fecha_operacion' => $transito->fecha_operacion,
                    'fecha_valor' => $transito->fecha_valor,
                    'cargo' => $transito->cargo,
                    'abono' => $transito->abono,
                 ]);
                $transito->delete();
            }    
        }

        //volvemos a cargar depositos actualizado
        $depositos = Deposito::where('conciliado','!=',1)->whereDate('fecha','<=',$f_cierre)->get();
        $porAhora = ['26805','26869','26794','26831','26832','26852','26853','26856','26776','26782','26848',
                    '26735','26803','26817','26851'];
        foreach ($ingresos as $item) {

            if (in_array($item->referencia, $porAhora)){
                Transito::create([
                    'fecha_operacion' => $item->fecha_operacion,
                    'referencia' => $item->referencia,
                    'descripcion' => $item->descripcion,
                    'fecha_valor' => $item->fecha_valor,
                    'cargo' => $item->cargo,
                    'abono' => $item->abono,
                ]);
                $item->update(['descripcion' =>'Transito']); 

            } else {
                if ($encontrado=$depositos->where('referencia',$item->referencia)->first())
                {
                    $estud = Estudiante::find($encontrado->estudiante_id);
                    $recibo = Recibo::find($encontrado->recibo_id);
                    $encontrado->update([
                        'fec_conciliacion' => $f_cierre,              
                        'conciliado'=> 1,
                    ]);
                    array_push($a_conciliado, (object)[
                        'referencia'=>$item->referencia,
                        'banco_id' => $item->id,
                        'recibo' => ($recibo) ? $recibo->no_recibo : '----',
                        'no_doc' => $estud->no_doc,                    
                        'nombre' => $estud->nombre,
                        'banco_fecha' =>$item->fecha_operacion,
                        'deposito_fecha'=>$encontrado->fecha,
                        'banco_monto' =>$item->abono,
                        'monto_otro' =>0,
                        'deposito_monto'=>$encontrado->monto,
                        'transito'=>false,                
                    ]);
                    $item->update(['descripcion' =>'Conciliado']); 


                } else {
    
                    Transito::create([
                        'fecha_operacion' => $item->fecha_operacion,
                        'referencia' => $item->referencia,
                        'descripcion' => $item->descripcion,
                        'fecha_valor' => $item->fecha_valor,
                        'cargo' => $item->cargo,
                        'abono' => $item->abono,
                    ]);
                    $item->update(['descripcion' =>'Transito']); 

                }
            }    
           
        }
        $ganancias = array_sum(array_column($a_conciliado, 'banco_monto'));
        
        $conciliados = $a_conciliado;
        $saldo_anterior = $saldo_anterior->abono;
        $comisiones = $comisiones->sum('cargo');
        $transferencias = $transferencias->sum('cargo');
        $ganancias = array_sum(array_column($a_conciliado, 'banco_monto'));
        $transito = Transito:: where('abono','>' , 0)
                ->whereMonth('fecha_operacion', $mes)
                ->whereYear('fecha_operacion',$ano)
                ->sum('abono'); 
        $monto_anterior = array_sum(array_column($a_conciliado, 'monto_otro'));
        $resumen = Cierre::create([
            'mes' => $mes,
            'ano' => $ano,
            'fecha_cierre'=>$f_cierre,
            'saldo_anterior'=>$saldo_anterior,
            'comisiones' => $comisiones,
            'transferencias' =>$transferencias,
            'ingresos' =>$ganancias+$monto_anterior,
            'ingreso_anterior'=>$monto_anterior,
            'transito'=>$transito,
        ]);
        $transito = Transito::All();
        Diario::where('consignado',1)->whereMonth('f_operacion','<=', $mes)->whereYear('f_operacion','<=',$ano)->delete();
        Diario::where('importe','<=',0)->whereMonth('f_operacion','<=', $mes)->whereYear('f_operacion','<=',$ano)->delete();
        Banco::truncate();
        return view('back.bancos.showConcilia', compact(['transito','conciliados','resumen','periodo']));
    }


    public function importDiario(Request $request) 
    {
        //       Diario::truncate();
        try {
            Excel::import(new DiarioImport, request()->file('diario_excel'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();
                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $err=$failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                }
                            
            $notification = [
                'type' => 'error',
                'title' => 'Error Archivo!!!',
                'message' => $err,
            ];
            return back()->with('notification', $notification);
        }
        Diario::whereNull('f_operacion')->delete();
        Banco::truncate();
        $notification = [
            'type' => 'success',
            'title' => 'TODO BIEN!!!',
            'message' => 'SE CARGO EL ARCHIVO EXCEL',
        ];

        
        return redirect()->route('back.bancos.index_diario')->with('notification', $notification);
    }


    public function Resumen(Request $request) 
    {
     
        $periodo = $request->periodo;
        $resumen = Cierre::find($request->resumen);
        return view('back.bancos.conciliado', compact(['resumen','periodo']));
    }

    public function excelResumen(Request $request){
        $periodo = $request->periodo;
        $resumen_cierre = Cierre::find($request->resumen);
        $nombre_archivo= 'cierre_'.$periodo.".xlsx";
        $data = compact(['periodo', 'resumen_cierre']);
        $vista = 'back.bancos.excel_resumen';
        $titulo = 'conciliación';
        return Excel::download(new GeneralExport($vista,$data,$titulo), $nombre_archivo);
    }

    public function pdfResumen(Request $request)
    {
        $periodo = $request->periodo;
        $resumen = Cierre::find($request->resumen);
        $pdf = PDF::loadView('back.bancos.pdf_resumen', compact(['periodo','resumen']));
        $pdf->setPaper('letter','landscape');
       
        return $pdf->stream('cierre_'.$periodo.'.pdf');

    }

    public function mesMenor ($fecha1, $fecha2) {
        if ($fecha1->isBefore($fecha2)) {
            $diferencia_en_meses = $fecha1->diffInMonths($fecha2);
            if ($diferencia_en_meses > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    function esDeMesesAnteriores($fecha1, $fecha2) {
        $carbon1 = $fecha1 instanceof Carbon ? $fecha1 : Carbon::parse($fecha1);
        $carbon2 = $fecha2 instanceof Carbon ? $fecha2 : Carbon::parse($fecha2);
        
        // Comparar año y mes
        return $carbon1->year < $carbon2->year || 
            ($carbon1->year === $carbon2->year && $carbon1->month < $carbon2->month);
    }

    function esDeMesesAnterioresV2($fecha1, $fecha2) {
        $carbon1 = $fecha1 instanceof Carbon ? $fecha1 : Carbon::parse($fecha1);
        $carbon2 = $fecha2 instanceof Carbon ? $fecha2 : Carbon::parse($fecha2);
        
        // Usar el método diffInMonths con signed=true para obtener diferencia con signo
        return $carbon1->diffInMonths($carbon2, true) > 0;
    }

    function diferenciaMeses($fecha1, $fecha2) {
        $carbon1 = $fecha1 instanceof Carbon ? $fecha1 : Carbon::parse($fecha1);
        $carbon2 = $fecha2 instanceof Carbon ? $fecha2 : Carbon::parse($fecha2);
        
        $diff = $carbon1->diffInMonths($carbon2, true);


        if ($diff > 0) {
            return "La fecha1 es $diff mes(es) anterior(es) a fecha2";
        } elseif ($diff < 0) {
            return "La fecha1 es " . abs($diff) . " mes(es) posterior(es) a fecha2";
        } else {
            return "Las fechas están en el mismo mes";
        }        


        if ($diff > 0) {
            return "La fecha1 es $diff mes(es) anterior(es) a fecha2";
        } elseif ($diff < 0) {
            return "La fecha1 es " . abs($diff) . " mes(es) posterior(es) a fecha2";
        } else {
            return "Las fechas están en el mismo mes";
        }
    }


}


