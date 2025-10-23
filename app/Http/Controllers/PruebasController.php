<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Userlog;
use App\Models\Divisa;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Programa;
use App\Models\Mencion;
use App\Models\Transito;
use App\Models\Banco;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Estudiante;
use App\Models\Recibo;
use App\Models\Pag_programa;
use Carbon\Carbon;
use App\Models\Arancel;
use App\Models\Matricula;
use App\Models\User;
use App\Models\Decanato;
use App\Models\Cierre;
use App\Models\Deposito;
use App\Models\Diario;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransitoExport;
use Illuminate\Support\Facades\DB;

class PDF extends FPDF
{

    function setAnulado()
    {
        $this->SetFont('Times', 'B', 40);
        $this->SetTextColor(237, 126, 117);
        $watermarkText = 'ANULADO';
        $this->addWatermark(60, 65, $watermarkText, 15);
        $this->addWatermark(60, 120, $watermarkText, 15);
        $this->addWatermark(60, 195, $watermarkText, 15);
        $this->SetTextColor(0,0,0);
 
    }

    function addWatermark($x, $y, $watermarkText, $angle)
    {
        $angle = $angle * M_PI / 180;
        $c = cos($angle);
        $s = sin($angle);
        $cx = $x * $this->k;
        $cy = ($this->h - $y) * $this->k;
        $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, - $s, $c, $cx, $cy, - $cx, - $cy));
        $this->Text($x, $y, $watermarkText);
        $this->_out('Q');
    }
}

class PruebasController extends Controller
{

   public function exportar() {

       $periodo ="Junio-2025";
       $data=compact(['periodo']);
        return Excel::download(new TransitoExport($data), 'transito.xls');

    }

 

    public function mostrar_log()
    {
        $user = Usuario::with('userlogs')->withCount('userlogs')->get();

        dd($user);

        return view('/admin');

    }
   // =================================================================//
    // =================================================================//  
  


    public function imprimir()
    {
        
        ob_end_clean();
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->setAnulado();
        $pdf->SetFont('Arial', '', 12);
        $pdfDocumentContent = utfToIso("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. .\n\n");
        for ($i = 0; $i < 15; $i ++) {
            $pdf->MultiCell(0, 5, $pdfDocumentContent, 0, 'J');
        }
        $pdf->Output('I', 'report.pdf');
    
    }


    public function mostrar_dolar()
    {
        $dolar_bcv = 1;

        $data = file_get_contents("https://pydolarvenezuela-api.vercel.app/api/v1/dollar");
        if ($data == false) {
            $divisa = Divisa::orderBy('fecha', 'DESC')->first();
            if ($divisa) {
                $dolar_bcv = $divisa->dolar; 
            }            
            return $dolar_bcv;
        }   
     
        $cambio = json_decode($data,true);
        $dolar_bcv = $cambio['monitors']['bcv']['price'];
        $fecha_bcv = $cambio['monitors']['bcv']['last_update'];
        $hora_bcv = trim(substr($fecha_bcv,strpos($fecha_bcv,",")+1));
        $fecha_bcv = trim(substr($fecha_bcv,0,strpos($fecha_bcv,",")));
        $fecha = Carbon::createFromFormat('d/m/Y', $fecha_bcv,'America/Caracas')->toDate();
        $divisa = Divisa::whereDate('fecha',$fecha)->first();
        if (!$divisa) {
            Divisa::create([
                'divisa' => 'dolar',  
                'fecha' => $fecha,              
                'valor'=> $dolar_bcv,
            ]);
        } else {

            $dolar_bcv = $divisa->valor;
            dd('Dolar: '.$divisa->valor);
        }
       // session(['DOLAR' => $dolar]);
        dd('Dolar: '.$dolar_bcv);
        return $dolar_bcv;
    }
    // =================================================================//
    // =================================================================//
    public function arreglos()
    {
        $a_divisas = Divisa::orderBy('fecha')->get()->toArray();

        $cont = 0;
        $valor_ayer = 0;
        foreach ($a_divisas as &$divisa) {
            if ($cont == 0) {
                $divisa["variacion"] = number_format($cont,2);
            } else {
                $divisa["variacion"] = number_format((($divisa["valor"]-$valor_ayer)/$valor_ayer)*100,2);
            }  
            $valor_ayer = $divisa['valor']; 
            $cont++;
        }

        $a_divisas= json_encode($a_divisas,JSON_PRETTY_PRINT);
        dd($a_divisas);

        return view('/admin');
 
    }

    public function showDivisas(){
        $a_divisas = Divisa::orderBy('fecha')->get()->toArray();
        $cont = 0;
        $valor_dolar_ayer = 0;
        $valor_euro_ayer = 0;
  
        foreach ($a_divisas as &$divisa) {
            if ($cont == 0) {
                $divisa["variacion_dolar"] = number_format($cont,2);
                $divisa["variacion_euro"] = number_format($cont,2);
 
            } else {
                $divisa["variacion_dolar"] = ($divisa["dolar"]== 0) ? 0 : number_format((($divisa["dolar"]-$valor_dolar_ayer)/$valor_dolar_ayer)*100,2);
                $divisa["variacion_euro"] = ($divisa["euro"]== 0) ? 0 : number_format((($divisa["euro"]-$valor_euro_ayer)/$valor_euro_ayer)*100,2);

            }  
            $valor_dolar_ayer = $divisa['dolar']; 
            $valor_euro_ayer = $divisa['euro']; 
            $cont++;
        }
        $a_divisas= json_encode($a_divisas,JSON_PRETTY_PRINT);
        dd($a_divisas);

        return view('/admin');


    }    

    public function programas()
    {
        $programas = Programa::with('menciones')->orderBy('programa')->get();
        $a_programas=[];

        foreach ($programas as $programa) {
            foreach ($programa->menciones as $mencion) {
                array_push($a_programas, (object)[
                    'id' => $mencion->id,
                    'programa' => $programa->programa,
                    'mencion' => $mencion->mencion,
                    'fecha' => $mencion->created_at->toDateString() ,
            ]);
            }

        }

        $datos = DataTables::of($a_programas)
        ->addColumn('DT_RowId', function ($row) {
            return $row->id;
        })
        ->toJson();
        
        dd($datos);

    }

    public function relaciones()
    {
        $recibo=Recibo::first();
        dd($recibo->estudiante->mencion->mencion);
        
        $estudiantes=Estudiante::with(['programa:id,programa','mencion:id,mencion'])->get();
        $a_estud=[];
        foreach ($estudiantes as $estudiante) {
            array_push($a_estud, (object)[
                'id' => $estudiante->id,
                'nombre'=>$estudiante->nombre,
                'programa' => $estudiante->programa->programa,
                'mencion' => $estudiante->mencion->mencion,
                'telefono' => $estudiante->telefono ,
                'direccion'=> $estudiante->direccion,
            ]);
            
        }
        dd($a_estud);
    
    }

    public function dropdown()
    {
         $programas =  Programa::orderBy('programa')->get();
         return view('back.estudiantes.dropdown', compact('programas'));

    }



    public function cambiar_data()
    {
        $recibos=Recibo::all();
        foreach ($recibos as $recibo) {
            if ($recibo->fecha_registro =='') {
                $recibo->update([
                    'fecha_registro' => null,
                ]);
            } else {

                $time = strtotime($recibo->fecha_registro);
                $newformat = date('Y-m-d',$time);
                $recibo->update([
                    'fecha_registro' => $newformat,
                ]);

            }

        }
        dd($newformat);
       
    
    }    

    public function recibos()
    {
        $recibos=Recibo::orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        foreach ($recibos as $recibo) {
            array_push($a_recibos, (object)[
                'id' => $recibo->id,
                'no_recibo'=>$recibo->no_recibo,
                'no_doc' => $recibo->no_doc,
                'nombre' => $recibo->estudiante->nombre,
                'programa' => $recibo->estudiante->programa->programa,
                'mencion'=>  $recibo->estudiante->mencion->mencion,
                'concepto'=> $recibo->concepto,
                'fecha' => $recibo->fecha,
                'status'=> $recibo->status,
            ]);
            
        }
        dd($a_recibos);
    
    }
    public function dolar_del_dia()
    {
        
        $date = '30-05-2024';
        $tasa = tasaDeFecha($date);
        
        if(!$tasa) {
            dd('tasa con error:'.$tasa);
        }else{
           
            dd('El dolar al: '.$date.' era de:'.$tasa);
        }
    }


    public function costo_programa($paginas,$nac)
    {
        $valor_base = 0;
        $van_pag = 0;
        $tabla=Pag_programa::orderBy('limite','ASC')->get();
        foreach ($tabla as $item) {
            if ($paginas > $item->limite){
                if ($nac=='VE'){
                    $valor_base = $valor_base + (($item->limite-$van_pag)*$item->costo_v);
                } else {
                    $valor_base = $valor_base + (($item->limite-$van_pag)*$item->costo_e);
                }
                $van_pag =  $item->limite;
            } else {
               
                if ($nac=='VE'){
                    $valor_base = $valor_base + (($paginas-$van_pag)*$item->costo_v);
                } else {
                    $valor_base = $valor_base + (($paginas-$van_pag)*$item->costo_e);
                }    
               break;
            }
        }
        $costo = $valor_base;
        return $costo;
    }

    
    public function costo_paginas()
    {
        $total_pag = 250;
        $monto = $this->costo_programa($total_pag,'EX');
        dd($monto);
        return $monto;
    }

    public function crear_cierre_mes()
    {  
        $fecha = Carbon::parse('2025-03-01');
        $saldo = 115836.93;
        Banco::truncate();
        Transito::truncate();
        Cierre::truncate();
        Deposito::where('conciliado', 1)
       ->update([
           'conciliado' => 0,
           'fec_conciliacion'=>null
        ]);

        Banco::create([
            'descripcion'=>'SALDO ANTERIOR',
            'abono'=>$saldo,            
            'saldo'=>$saldo,            
        ]);
        $fecha->addDays(2);
        Banco::create([
            'fecha_operacion'=> $fecha,
            'referencia'=>'25025',
            'descripcion'=>'CAR PNCASH.P.PR     00000001  083000000',
            'fecha_valor'=> $fecha,
            'cargo'=>$saldo,            
            'saldo'=>0,            
        ]);
        $fecha->addDays(1);
        $saldo=0;
        Banco::create([
            'fecha_operacion'=> $fecha,
            'referencia'=>'25026',
            'descripcion'=>'COMIS PGPR PNCASH. DOMICIL.',
            'fecha_valor'=> $fecha,
            'cargo'=>0.81,            
            'saldo'=>$saldo+=-0.81,            
        ]);
        $fecha = Carbon::parse('2025-03-01');
   
        $recibos=Recibo::whereMonth('fecha_recibo', $fecha->month)
        ->whereYear('fecha_recibo', $fecha->year)
        ->where('status','VIGENTE')
        ->get();

        foreach ($recibos as $recibo) {
            foreach ($recibo->depositos as $deposito) {

                if (date("m",strtotime($deposito->fecha))==$fecha->month) {
                    Banco::create([
                        'fecha_operacion'=> $deposito->fecha,
                        'fecha_valor'=> $deposito->fecha,
                        'referencia'=>$deposito->referencia,
                        'descripcion'=>'TPBW V00'.$recibo->no_doc.' TELESERVICIOS',
                        'abono'=>$deposito->monto,            
                        'saldo'=>$saldo+=$deposito->monto,            
                    ]);
                } else {
                    Transito::create([
                        'fecha_operacion'=> $deposito->fecha,
                        'fecha_valor'=> $deposito->fecha,
                        'referencia'=>$deposito->referencia,
                        'descripcion'=>'TPBW V00'.$recibo->no_doc.' TELESERVICIOS',
                        'abono'=>$deposito->monto,            
                    ]);

                }

            }

        }

        Banco::create([
            'fecha_operacion'=> '2025-03-31',
            'referencia'=>'99880',
            'descripcion'=>'TPBW V007222809 TELESERVICIOS',
            'fecha_valor'=> '2025-03-31',
            'abono'=>2350,         
            'saldo'=>$saldo+=2350,            
               
        ]);
        Banco::create([
            'fecha_operacion'=> '2025-03-31',
            'referencia'=>'99881',
            'descripcion'=>'TPBW V007222809 TELESERVICIOS',
            'fecha_valor'=> '2025-03-31',
            'abono'=>50,         
            'saldo'=>$saldo+=50,            
               
        ]);


        return redirect('/back/bancos');;
    }


    public function ajax_cierre(Request $request) 
    {
        $banco=Banco::get();
        foreach ($banco as $deposito) {
                $consignado=Deposito::where('numero',trim($deposito->referencia))->first();
                if($consignado){
                    $deposito->update(['consignado'=>1]);
                } 
        }
        return DataTables::of($banco)
                ->toJson();
    }

    public function buscaIdProgramas(){
        $a_programas=[];
        $programas = Arancel::where('monto_venezolano',0)->get();
        if($programas->isNotEmpty()){
            foreach ($programas as $programa) {
                    array_push($a_programas, (object)[
                        'id' => $programa->id,
                        'tipo'=>'Arancel'
                    ]);
            }
        } 
        $programas = Matricula::where('monto_venezolano',0)->get();
        if($programas->isNotEmpty()){
                foreach ($programas as $programa) {
                        array_push($a_programas, (object)[
                            'id' => $programa->id,
                            'tipo'=>'Matricula'
                        ]);
                }
        } 
        $cool = collect($a_programas);
        $ids = [10,11,3,4,5];
        $x='lleno';
        $a = $cool->where('tipo','Arancel')->whereIn('id',$ids);
        if ($a->isEmpty()) {
            $x = 'Vacio';
        }
        dd($x); 
        return $cool;

     }

     public function diarioMes() {
        Banco::truncate();
        $saldo_inicial = 906863.15;
        $saldo=$saldo_inicial;
        $diarios=Diario::orderBy('f_operacion','asc')->get(); 
        $abono=0;
        $cargo=0;
        Banco::create([
            'descripcion'=>'SALDO ANTERIOR',
            'abono'=>$saldo_inicial,            
            'saldo'=>$saldo_inicial,            
        ]);
        foreach ($diarios as $diario) {
            if ($diario->importe>0) {
                $abono=$diario->importe;
                $cargo = 0;
                $saldo+=$abono;
            } else {
                $cargo = $diario->importe;
                $abono=0;
                $saldo+=$cargo;
            }
            Banco::create([
                'fecha_operacion'=>$diario->f_operacion,
                'fecha_valor'=>$diario->f_valor,
                'referencia'=>$diario->no_doc,
                'descripcion'=>$diario->concepto,
                'abono'=>$abono,
                'cargo'=>$cargo,
                'saldo'=>$saldo,
            ]);
        }

       return redirect('/back/bancos');
 

     }   

     public function resultados(){
        $depositos=Deposito::whereDate('fecha','<','2025-07-01')->get();
        $t_depositos=$depositos->sum('monto');
        $t_conciliado=$depositos->where('conciliado',1)->sum('monto');
        $t_transito=$depositos->where('conciliado',0)->sum('monto');

        echo 'Total Depositos='.formatMoney($t_depositos);
        echo "<br><br><br><br>";
        echo 'Conciliado='.formatMoney($t_conciliado);
        echo "<br>";
        echo 'transito='.formatMoney($t_transito);
        echo "<br>";
        echo 'Total suma='.formatMoney($t_conciliado+$t_transito);
        echo "<br>";



        return;
     }

// hechar para atras un cierre
// ===========================
    public function cierre_rollback(){
        $mes_cierre = 7;
        $ano_cierre = 2025;
        $cierre = Cierre::where('mes',$mes_cierre)->where('ano',$ano_cierre)->first();
        Deposito::whereDate('fec_conciliacion', $cierre->fecha_cierre)->update([
           'conciliado' => 0,
           'fec_conciliacion'=>null
        ]);
        Transito::whereMonth('fecha_operacion', $mes_cierre)
        ->whereYear('fecha_operacion', $ano_cierre)
        ->delete();

        DB::table('historico_transitos')->whereDate('fecha_cierre',$cierre->fecha_cierre)->delete();
        Cierre::where('mes',$mes_cierre)->where('ano',$ano_cierre)->delete();
       return redirect('/back/bancos');

    } 

}
