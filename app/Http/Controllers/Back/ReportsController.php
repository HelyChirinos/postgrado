<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Recibo;
use App\Models\Matricula;
use App\Models\Arancel;
use App\Models\Constancia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteFullExport;
use Illuminate\Support\Carbon;
use App\Models\Cierre;
use App\Exports\ConstanciaExport;
use App\Exports\GeneralExport;

class ReportsController extends Controller
{
    
    public function index(Request $request)
    {

        return view('back.reportes.index');
    }



    public function prueba()
    {
        $pdf = PDF::loadView('back.reportes.prueba');
        $pdf->setPaper('letter','portrait');

            // return view('back.reportes.prueba');
        return $pdf->stream('prueba.pdf');
    }

    public function resumen_mes(Request $request){
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $num_mes = (int) $mes;
        if ($resumen=Cierre::where('mes',$num_mes)->where('ano',$ano)->first())
        {
            return view('back.bancos.conciliado', compact(['resumen','periodo']));
        } else {
            $notification = [
                'type' => 'error',
                'title' => 'Error Periodo: '.$periodo,
                'message' => 'NO HA HABIDO CIERRE DE ESTE MES',
            ];
            return redirect()->route('back.reportes.index')->with('notification', $notification);

        }



    }

    public function repo_recibos_completo(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        $total_const=0;
        
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $pdf_periodo = $request->periodo;

        $resumen=[];
        $recibos=[];
        $this->request_multiple($recibos, $mes, $ano, $resumen);
        return view('back.reportes.reporte_multiple', compact(['recibos','periodo', 'pdf_periodo', 'resumen']));
    }

    public function ExcelFullRecibos(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        $mes_cierre= number_format($mes);
        $total_const=0;
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $pdf_periodo = $request->periodo;

        $resumen=[];
        $recibos=[];
        $resumen_cierre= Cierre::where('mes',$mes_cierre)->where('ano',$ano)->first();
        $this->request_multiple($recibos, $mes, $ano, $resumen);
        $data = compact(['recibos','periodo', 'resumen', 'resumen_cierre','mes','ano']);
        $nombre_archivo= $periodo.".xlsx";
        return Excel::download(new ReporteFullExport($data), $nombre_archivo);
 
    }


    public function pdf_recibos_completo(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        $total_const=0;
        
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $pdf_periodo = $request->periodo;

        $resumen=[];
        $recibos=[];
        $this->request_multiple($recibos, $mes, $ano, $resumen);
        $pdf = PDF::loadView('back.reportes.pdf_recibos_completo', compact(['recibos','periodo','resumen']));
        $pdf->setPaper('letter','landscape');
        return $pdf->stream('recibos_mes.pdf');

    }


    public function repo_recibos_mes(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $pdf_periodo = $request->periodo;
        $resumen=[];
        $recibos=[];
        $this->request_multiple($recibos, $mes, $ano, $resumen);
        $total_depositos = $resumen[0]->total_depositos+$resumen[0]->total_depositos_ant;
        $total_recibos = $resumen[0]->total_arancel+$resumen[0]->total_arancel_ant+ $resumen[0]->total_matricula + $resumen[0]->total_matricula_ant;
        return view('back.reportes.reporte_recibos', compact(['recibos','periodo', 'pdf_periodo','resumen','total_depositos','total_recibos']));
    }

    public function repo_recibos_completo_periodo(Request $request)
    {
        $desde= $request->desde;
        $hasta= $request->hasta;
        $tmp_recibos=Recibo::with('depositos')
        ->where('fecha_recibo', '>=', $desde)
        ->where('fecha_recibo', '<=', $hasta)
        ->orderBy('no_recibo','DESC')->get();
        $total_cosnt=0;
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_arancel=0;
        $total_matricula=0;
        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            foreach ($recibo->depositos as $deposito ) {
                array_push($a_depositos, (object)[
                    'recibo_id' => $recibo->id,
                    'fecha_depo' =>$deposito->fecha,
                    'no_depo' =>$deposito->numero,
                    'monto_depo' =>$deposito->monto,
                ]);
                $cont_depositos++;
                $total_depositos=$total_depositos+$deposito->monto;
            }
            foreach ($recibo->constancias as $constancia ) {
                $total_const = $total_const+$constancia->monto_bs;
                array_push($a_constancias, (object)[
                    'recibo_id' => $recibo->id,
                    'tipo' =>$constancia->tipo,
                    'monto_bs' =>$constancia->monto_bs,
                    'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                ]);
                if($constancia->tipo=='ARANCEL'){
                    $total_arancel=$total_arancel+$constancia->monto_bs;
                }
                if($constancia->tipo=='MATRICULA'){
                    $total_matricula=$total_matricula+$constancia->monto_bs;
                }
                if($constancia->tipo=='OTRO'){
                    $total_otro=$total_otro+$constancia->monto_bs;
                }
            }

            array_push($a_recibos, (object)[
                'id' => $recibo->id,
                'no_recibo'=>$recibo->no_recibo,
                'fecha' => $recibo->fecha_recibo,
                'no_doc' => $recibo->no_doc,
                'nombre' => $recibo->estudiante->nombre,
                'depositos' => $a_depositos,
                'constancias' => $a_constancias,
                'programa' => ucfirst($recibo->estudiante->programa->programa),
                'total' => $total_const
            ]);
        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;

        $resumen=[];
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_arancel'=>$total_arancel,
            'total_matricula'=>$total_matricula,
            'total_otros'=>$total_otro,
        ]);
        return view('back.reportes.reporte_recibos_completo_periodo', compact(['recibos','desde', 'hasta', 'total', 'resumen']));
    }

    public function pdf_recibos_completo_periodo(Request $request)
    {
        $desde= $request->desde;
        $hasta= $request->hasta;
        $tmp_recibos=Recibo::with('depositos')
        ->where('fecha_recibo', '>=', $desde)
        ->where('fecha_recibo', '<=', $hasta)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_arancel=0;
        $total_matricula=0;
        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            foreach ($recibo->depositos as $deposito ) {
                array_push($a_depositos, (object)[
                    'recibo_id' => $recibo->id,
                    'fecha_depo' =>$deposito->fecha,
                    'no_depo' =>$deposito->numero,
                    'monto_depo' =>$deposito->monto,
                ]);
                $cont_depositos++;
                $total_depositos=$total_depositos+$deposito->monto;
            }
            foreach ($recibo->constancias as $constancia ) {
                $total_const = $total_const+$constancia->monto_bs;
                array_push($a_constancias, (object)[
                    'recibo_id' => $recibo->id,
                    'tipo' =>$constancia->tipo,
                    'monto_bs' =>$constancia->monto_bs,
                    'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                ]);
                if($constancia->tipo=='ARANCEL'){
                    $total_arancel=$total_arancel+$constancia->monto_bs;
                }
                if($constancia->tipo=='MATRICULA'){
                    $total_matricula=$total_matricula+$constancia->monto_bs;
                }
                if($constancia->tipo=='OTRO'){
                    $total_otro=$total_otro+$constancia->monto_bs;
                }
            }

            array_push($a_recibos, (object)[
                'id' => $recibo->id,
                'no_recibo'=>$recibo->no_recibo,
                'fecha' => $recibo->fecha_recibo,
                'no_doc' => $recibo->no_doc,
                'nombre' => $recibo->estudiante->nombre,
                'depositos' => $a_depositos,
                'constancias' => $a_constancias,
                'programa' => ucfirst($recibo->estudiante->programa->programa),
                'total' => $total_const
            ]);
        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;

        $resumen=[];
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_arancel'=>$total_arancel,
            'total_matricula'=>$total_matricula,
            'total_otros'=>$total_otro,
        ]);
  
        $pdf = PDF::loadView('back.reportes.pdf_recibos_completo_periodo', compact(['recibos','desde','hasta','total','resumen']));
        $pdf->setPaper('letter','landscape');
        return $pdf->stream('recibos_periodo.pdf');

    }

    public function repo_recibos_arancel(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        $total_const=0;
        
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $pdf_periodo = $request->periodo;

        $tmp_recibos=Recibo::with('depositos')->with('constancias')
        ->has('aranceles')
        ->whereMonth('fecha_recibo', $mes)
        ->whereYear('fecha_recibo', $ano)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_arancel=0;
        $total_matricula=0;
        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            if (!is_null($recibo->aranceles)) {
                foreach ($recibo->depositos as $deposito ) {
                    array_push($a_depositos, (object)[
                        'recibo_id' => $recibo->id,
                        'fecha_depo' =>$deposito->fecha,
                        'no_depo' =>$deposito->numero,
                        'monto_depo' =>$deposito->monto,
                    ]);
                    $cont_depositos++;
                    $total_depositos=$total_depositos+$deposito->monto;
                }
                foreach ($recibo->constancias as $constancia ) {
                    if($constancia->tipo=='ARANCEL'){ 
                        $total_const = $total_const+$constancia->monto_bs;
                        array_push($a_constancias, (object)[
                            'recibo_id' => $recibo->id,
                            'tipo' =>$constancia->tipo,
                            'monto_bs' =>$constancia->monto_bs,
                            'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                        ]);
                        $total_arancel=$total_arancel+$constancia->monto_bs;
                    }                    
                }

                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'no_doc' => $recibo->no_doc,
                    'nombre' => $recibo->estudiante->nombre,
                    'depositos' => $a_depositos,
                    'constancias' => $a_constancias,
                    'programa' => ucfirst($recibo->estudiante->programa->programa),
                    'total' => $total_const
                ]);
            } 
        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;

        $resumen=[];
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_arancel'=>$total_arancel,
        ]);
        return view('back.reportes.reporte_aranceles_mes', compact(['recibos','periodo', 'pdf_periodo', 'total', 'resumen']));
    }

   public function repo_recibos_constancias(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        $total_const=0;
        
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $pdf_periodo = $request->periodo;

        $tmp_recibos=Recibo::with('depositos')->with('constancias')
        ->has('aranceles')
        ->whereMonth('fecha_recibo', $mes)
        ->whereYear('fecha_recibo', $ano)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_arancel=0;
        $total_matricula=0;
        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            if (!is_null($recibo->aranceles)) {
                foreach ($recibo->depositos as $deposito ) {
                    array_push($a_depositos, (object)[
                        'recibo_id' => $recibo->id,
                        'fecha_depo' =>$deposito->fecha,
                        'no_depo' =>$deposito->numero,
                        'monto_depo' =>$deposito->monto,
                    ]);
                    $cont_depositos++;
                    $total_depositos=$total_depositos+$deposito->monto;
                }
                foreach ($recibo->constancias as $constancia ) {
                    if($constancia->tipo=='ARANCEL'){ 
                        if ($this->es_constancia($constancia->tipo_id)) {
                           $mostrar=true; 
                           $total_const = $total_const+$constancia->monto_bs;
                            array_push($a_constancias, (object)[
                                'recibo_id' => $recibo->id,
                                'tipo' =>$constancia->tipo,
                                'monto_bs' =>$constancia->monto_bs,
                                'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                            ]);
                            $total_arancel=$total_arancel+$constancia->monto_bs;

                        }
                    }                    
                }
                if (count($a_constancias)>0) {
                    array_push($a_recibos, (object)[
                        'id' => $recibo->id,
                        'no_recibo'=>$recibo->no_recibo,
                        'fecha' => $recibo->fecha_recibo,
                        'no_doc' => $recibo->no_doc,
                        'nombre' => $recibo->estudiante->nombre,
                        'depositos' => $a_depositos,
                        'constancias' => $a_constancias,
                        'programa' => ucfirst($recibo->estudiante->programa->programa),
                        'total' => $total_const
                    ]);

                }
            } 
        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;

        $resumen=[];
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_arancel'=>$total_arancel,
        ]);
        return view('back.reportes.reporte_detalle_constancias_mes', compact(['recibos','periodo', 'pdf_periodo', 'total', 'resumen']));
    }


    public function repo_constancias_mes(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        $total_const=0;
        
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $pdf_periodo = $request->periodo;

        $tmp_recibos=Recibo::with('constancias')
        ->whereMonth('fecha_recibo', $mes)
        ->whereYear('fecha_recibo', $ano)
        ->orderBy('no_recibo','DESC')->get();
        
        $total_arancel=0;
        $a_constancias=[];
        $total_const=0;
        $total=0;
        $cont=0;
        $aranceles = Arancel::where('constancia', 1)->get();
        foreach ($aranceles as $arancel) {
            $total_arancel=0;
            foreach ($tmp_recibos as $recibo) {
                $recibo_const=Constancia::where('recibo_id',$recibo->id)->where('tipo', 'ARANCEL')->where('tipo_id',$arancel->id)->first();
                if ($recibo_const) {
                    $total_arancel=$total_arancel+$recibo_const->monto_bs;
                }
            }
            if ($total_arancel>0) {
                $ochenta = $total_arancel*0.8;
                $veinte = $total_arancel*0.2;
                array_push($a_constancias, (object)[
                    'constancia' => $arancel->arancel,
                    'total_constancia' => $total_arancel,
                    'total80'=> $ochenta,
                    'total20'=>$veinte
                ]);
                $cont=$cont+1;

            }
 
        } 
        $sumTotal =array_sum(array_column($a_constancias, 'total_constancia'));
        $sum80 = array_sum(array_column($a_constancias, 'total80'));
        $sum20 = array_sum(array_column($a_constancias, 'total20'));    
    
       return view('back.reportes.reporte_constancias_mes', compact(['periodo', 'pdf_periodo', 'a_constancias', 
        'sumTotal', 'sum80', 'sum20', 'cont']));
    }

    public function excel_constancias_mes(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        $total_const=0;
        
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $pdf_periodo = $request->periodo;

        $tmp_recibos=Recibo::with('constancias')
        ->whereMonth('fecha_recibo', $mes)
        ->whereYear('fecha_recibo', $ano)
        ->orderBy('no_recibo','DESC')->get();
        
        $total_arancel=0;
        $a_constancias=[];
        $total_const=0;
        $total=0;
        $cont=0;
        $aranceles = Arancel::where('constancia', 1)->get();
        foreach ($aranceles as $arancel) {
            $total_arancel=0;
            foreach ($tmp_recibos as $recibo) {
                $recibo_const=Constancia::where('recibo_id',$recibo->id)->where('tipo', 'ARANCEL')->where('tipo_id',$arancel->id)->first();
                if ($recibo_const) {
                    $total_arancel=$total_arancel+$recibo_const->monto_bs;
                }
            }
            if ($total_arancel>0) {
                $ochenta = $total_arancel*0.8;
                $veinte = $total_arancel*0.2;
                array_push($a_constancias, (object)[
                    'constancia' => $arancel->arancel,
                    'total_constancia' => $total_arancel,
                    'total80'=> $ochenta,
                    'total20'=>$veinte
                ]);
                $cont=$cont+1;

            }
 
        } 
        $sumTotal =array_sum(array_column($a_constancias, 'total_constancia'));
        $sum80 = array_sum(array_column($a_constancias, 'total80'));
        $sum20 = array_sum(array_column($a_constancias, 'total20')); 
        $data= compact(['periodo', 'pdf_periodo', 'a_constancias', 'sumTotal', 'sum80', 'sum20', 'cont']);
        $nombre_archivo= 'constancias-'.$periodo.".xlsx";
        $vista = 'back.reportes.excel_constancias_mes';
        $titulo ='constancias';
        return Excel::download(new ConstanciaExport($data), $nombre_archivo);

    }


    public function pdf_aranceles_mes(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        $total_const=0;
        
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $pdf_periodo = $request->periodo;

        $tmp_recibos=Recibo::with('depositos')->with('constancias')
        ->has('aranceles')
        ->whereMonth('fecha_recibo', $mes)
        ->whereYear('fecha_recibo', $ano)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_arancel=0;
        $total_matricula=0;
        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            if (!is_null($recibo->aranceles)) {
                foreach ($recibo->depositos as $deposito ) {
                    array_push($a_depositos, (object)[
                        'recibo_id' => $recibo->id,
                        'fecha_depo' =>$deposito->fecha,
                        'no_depo' =>$deposito->numero,
                        'monto_depo' =>$deposito->monto,
                    ]);
                    $cont_depositos++;
                    $total_depositos=$total_depositos+$deposito->monto;
                }
                foreach ($recibo->constancias as $constancia ) {
                    if($constancia->tipo=='ARANCEL'){ 
                        $total_const = $total_const+$constancia->monto_bs;
                        array_push($a_constancias, (object)[
                            'recibo_id' => $recibo->id,
                            'tipo' =>$constancia->tipo,
                            'monto_bs' =>$constancia->monto_bs,
                            'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                        ]);
                        $total_arancel=$total_arancel+$constancia->monto_bs;
                    }                    
                }

                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'no_doc' => $recibo->no_doc,
                    'nombre' => $recibo->estudiante->nombre,
                    'depositos' => $a_depositos,
                    'constancias' => $a_constancias,
                    'programa' => ucfirst($recibo->estudiante->programa->programa),
                    'total' => $total_const
                ]);
            } 
        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;

        $resumen=[];
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_arancel'=>$total_arancel,
        ]);
        $pdf = PDF::loadView('back.reportes.pdf_aranceles_mes', compact(['recibos','periodo','total', 'resumen']));
        $pdf->setPaper('letter','landscape');
        return $pdf->stream('Arancel_mes.pdf');
    }


    public function repo_recibos_arancel_periodo(Request $request)
    {
        $desde= $request->desde;
        $hasta= $request->hasta;
        $total_const=0;
        $tmp_recibos=Recibo::with('depositos')->with('constancias')
        ->has('aranceles')
        ->where('fecha_recibo', '>=', $desde)
        ->where('fecha_recibo', '<=', $hasta)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_arancel=0;
        $total_matricula=0;
        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            if (!is_null($recibo->aranceles)) {
                foreach ($recibo->depositos as $deposito ) {
                    array_push($a_depositos, (object)[
                        'recibo_id' => $recibo->id,
                        'fecha_depo' =>$deposito->fecha,
                        'no_depo' =>$deposito->numero,
                        'monto_depo' =>$deposito->monto,
                    ]);
                    $cont_depositos++;
                    $total_depositos=$total_depositos+$deposito->monto;
                }
                foreach ($recibo->constancias as $constancia ) {
                    if($constancia->tipo=='ARANCEL'){ 
                        $total_const = $total_const+$constancia->monto_bs;
                        array_push($a_constancias, (object)[
                            'recibo_id' => $recibo->id,
                            'tipo' =>$constancia->tipo,
                            'monto_bs' =>$constancia->monto_bs,
                            'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                        ]);
                        $total_arancel=$total_arancel+$constancia->monto_bs;
                    }                    
                }

                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'no_doc' => $recibo->no_doc,
                    'nombre' => $recibo->estudiante->nombre,
                    'depositos' => $a_depositos,
                    'constancias' => $a_constancias,
                    'programa' => ucfirst($recibo->estudiante->programa->programa),
                    'total' => $total_const
                ]);
            } 
        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;

        $resumen=[];
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_arancel'=>$total_arancel,
        ]);
        return view('back.reportes.reporte_aranceles_periodos', compact(['recibos','desde', 'hasta', 'total', 'resumen']));
    }

    public function pdf_aranceles_periodo(Request $request)
    {
        $desde= $request->desde;
        $hasta= $request->hasta;
        $total_const=0;
        $tmp_recibos=Recibo::with('depositos')->with('constancias')
        ->has('aranceles')
        ->where('fecha_recibo', '>=', $desde)
        ->where('fecha_recibo', '<=', $hasta)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_arancel=0;
        $total_matricula=0;
        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            if (!is_null($recibo->aranceles)) {
                foreach ($recibo->depositos as $deposito ) {
                    array_push($a_depositos, (object)[
                        'recibo_id' => $recibo->id,
                        'fecha_depo' =>$deposito->fecha,
                        'no_depo' =>$deposito->numero,
                        'monto_depo' =>$deposito->monto,
                    ]);
                    $cont_depositos++;
                    $total_depositos=$total_depositos+$deposito->monto;
                }
                foreach ($recibo->constancias as $constancia ) {
                    if($constancia->tipo=='ARANCEL'){ 
                        $total_const = $total_const+$constancia->monto_bs;
                        array_push($a_constancias, (object)[
                            'recibo_id' => $recibo->id,
                            'tipo' =>$constancia->tipo,
                            'monto_bs' =>$constancia->monto_bs,
                            'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                        ]);
                        $total_arancel=$total_arancel+$constancia->monto_bs;
                    }                    
                }

                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'no_doc' => $recibo->no_doc,
                    'nombre' => $recibo->estudiante->nombre,
                    'depositos' => $a_depositos,
                    'constancias' => $a_constancias,
                    'programa' => ucfirst($recibo->estudiante->programa->programa),
                    'total' => $total_const
                ]);
            } 
        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;

        $resumen=[];
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_arancel'=>$total_arancel,
        ]);
        $pdf = PDF::loadView('back.reportes.pdf_aranceles_periodo', compact(['recibos','desde','hasta','total', 'resumen']));
        $pdf->setPaper('letter','landscape');
        return $pdf->stream('Arancel_periodo.pdf');

    }

    public function repo_recibos_matricula(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        $total_const=0;
        
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $pdf_periodo = $request->periodo;

        $tmp_recibos=Recibo::with('depositos')->with('constancias')
        ->has('matriculas')
        ->whereMonth('fecha_recibo', $mes)
        ->whereYear('fecha_recibo', $ano)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_arancel=0;
        $total_matricula=0;
        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            if (!is_null($recibo->aranceles)) {
                foreach ($recibo->depositos as $deposito ) {
                    array_push($a_depositos, (object)[
                        'recibo_id' => $recibo->id,
                        'fecha_depo' =>$deposito->fecha,
                        'no_depo' =>$deposito->numero,
                        'monto_depo' =>$deposito->monto,
                    ]);
                    $cont_depositos++;
                    $total_depositos=$total_depositos+$deposito->monto;
                }
                foreach ($recibo->constancias as $constancia ) {
                    if($constancia->tipo=='MATRICULA'){ 
                        $total_const = $total_const+$constancia->monto_bs;
                        array_push($a_constancias, (object)[
                            'recibo_id' => $recibo->id,
                            'tipo' =>$constancia->tipo,
                            'monto_bs' =>$constancia->monto_bs,
                            'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                        ]);
                        $total_matricula=$total_matricula+$constancia->monto_bs;
                    }                    
                }

                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'no_doc' => $recibo->no_doc,
                    'nombre' => $recibo->estudiante->nombre,
                    'depositos' => $a_depositos,
                    'constancias' => $a_constancias,
                    'programa' => ucfirst($recibo->estudiante->programa->programa),
                    'total' => $total_const
                ]);
            } 
        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;

        $resumen=[];
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_matricula'=>$total_matricula,
        ]);
        return view('back.reportes.reporte_matriculas_mes', compact(['recibos','periodo', 'pdf_periodo', 'total', 'resumen']));
    }
    public function pdf_matricula_mes(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        $total_const=0;
        
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
        $pdf_periodo = $request->periodo;

        $tmp_recibos=Recibo::with('depositos')->with('constancias')
        ->has('matriculas')
        ->whereMonth('fecha_recibo', $mes)
        ->whereYear('fecha_recibo', $ano)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_arancel=0;
        $total_matricula=0;
        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            if (!is_null($recibo->aranceles)) {
                foreach ($recibo->depositos as $deposito ) {
                    array_push($a_depositos, (object)[
                        'recibo_id' => $recibo->id,
                        'fecha_depo' =>$deposito->fecha,
                        'no_depo' =>$deposito->numero,
                        'monto_depo' =>$deposito->monto,
                    ]);
                    $cont_depositos++;
                    $total_depositos=$total_depositos+$deposito->monto;
                }
                foreach ($recibo->constancias as $constancia ) {
                    if($constancia->tipo=='MATRICULA'){ 
                        $total_const = $total_const+$constancia->monto_bs;
                        array_push($a_constancias, (object)[
                            'recibo_id' => $recibo->id,
                            'tipo' =>$constancia->tipo,
                            'monto_bs' =>$constancia->monto_bs,
                            'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                        ]);
                        $total_matricula=$total_matricula+$constancia->monto_bs;
                    }                    
                }

                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'no_doc' => $recibo->no_doc,
                    'nombre' => $recibo->estudiante->nombre,
                    'depositos' => $a_depositos,
                    'constancias' => $a_constancias,
                    'programa' => ucfirst($recibo->estudiante->programa->programa),
                    'total' => $total_const
                ]);
            } 
        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;

        $resumen=[];
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_matricula'=>$total_matricula,
        ]);
        $pdf = PDF::loadView('back.reportes.pdf_matricula_mes', compact(['recibos','periodo','total', 'resumen']));
        $pdf->setPaper('letter','landscape');
        return $pdf->stream('Matricula_mes.pdf');
    }


    public function repo_recibos_matricula_periodo(Request $request)
    {
        $desde= $request->desde;
        $hasta= $request->hasta;
        $total_const=0;
        $tmp_recibos=Recibo::with('depositos')->with('constancias')
        ->has('matriculas')
        ->where('fecha_recibo', '>=', $desde)
        ->where('fecha_recibo', '<=', $hasta)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_arancel=0;
        $total_matricula=0;
        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            if (!is_null($recibo->aranceles)) {
                foreach ($recibo->depositos as $deposito ) {
                    array_push($a_depositos, (object)[
                        'recibo_id' => $recibo->id,
                        'fecha_depo' =>$deposito->fecha,
                        'no_depo' =>$deposito->numero,
                        'monto_depo' =>$deposito->monto,
                    ]);
                    $cont_depositos++;
                    $total_depositos=$total_depositos+$deposito->monto;
                }
                foreach ($recibo->constancias as $constancia ) {
                    if($constancia->tipo=='MATRICULA'){ 
                        $total_const = $total_const+$constancia->monto_bs;
                        array_push($a_constancias, (object)[
                            'recibo_id' => $recibo->id,
                            'tipo' =>$constancia->tipo,
                            'monto_bs' =>$constancia->monto_bs,
                            'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                        ]);
                        $total_matricula=$total_matricula+$constancia->monto_bs;
                    }                    
                }

                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'no_doc' => $recibo->no_doc,
                    'nombre' => $recibo->estudiante->nombre,
                    'depositos' => $a_depositos,
                    'constancias' => $a_constancias,
                    'programa' => ucfirst($recibo->estudiante->programa->programa),
                    'total' => $total_const
                ]);
            } 
        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;

        $resumen=[];
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_matricula'=>$total_matricula,
        ]);
        return view('back.reportes.reporte_matriculas_periodos', compact(['recibos','desde', 'hasta', 'total', 'resumen']));
    }

    public function pdf_matriculas_periodo(Request $request)
    {
        $desde= $request->desde;
        $hasta= $request->hasta;
        $total_const=0;
        $tmp_recibos=Recibo::with('depositos')->with('constancias')
        ->has('matriculas')
        ->where('fecha_recibo', '>=', $desde)
        ->where('fecha_recibo', '<=', $hasta)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_arancel=0;
        $total_matricula=0;
        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            if (!is_null($recibo->aranceles)) {
                foreach ($recibo->depositos as $deposito ) {
                    array_push($a_depositos, (object)[
                        'recibo_id' => $recibo->id,
                        'fecha_depo' =>$deposito->fecha,
                        'no_depo' =>$deposito->numero,
                        'monto_depo' =>$deposito->monto,
                    ]);
                    $cont_depositos++;
                    $total_depositos=$total_depositos+$deposito->monto;
                }
                foreach ($recibo->constancias as $constancia ) {
                    if($constancia->tipo=='MATRICULA'){ 
                        $total_const = $total_const+$constancia->monto_bs;
                        array_push($a_constancias, (object)[
                            'recibo_id' => $recibo->id,
                            'tipo' =>$constancia->tipo,
                            'monto_bs' =>$constancia->monto_bs,
                            'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                        ]);
                        $total_matricula=$total_matricula+$constancia->monto_bs;
                    }                    
                }

                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'no_doc' => $recibo->no_doc,
                    'nombre' => $recibo->estudiante->nombre,
                    'depositos' => $a_depositos,
                    'constancias' => $a_constancias,
                    'programa' => ucfirst($recibo->estudiante->programa->programa),
                    'total' => $total_const
                ]);
            } 
        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;

        $resumen=[];
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_matricula'=>$total_matricula,
        ]);
        $pdf = PDF::loadView('back.reportes.pdf_matriculas_periodo', compact(['recibos','desde','hasta','total', 'resumen']));
        $pdf->setPaper('letter','landscape');
        return $pdf->stream('Matriculas_periodo.pdf');

    }


    public function pdf_recibos_mes(Request $request)
    {
        $ano=substr($request->periodo,0,4);
        $mes=substr($request->periodo,5);
        
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $periodo = $meses[$mes - 1].'-'.$ano;
   
        $resumen=[];
        $recibos=[];
        $this->request_multiple($recibos, $mes, $ano, $resumen);
        $total_depositos = $resumen[0]->total_depositos+$resumen[0]->total_depositos_ant;
        $total_recibos = $resumen[0]->total_arancel+$resumen[0]->total_arancel_ant+ $resumen[0]->total_matricula + $resumen[0]->total_matricula_ant;
        $pdf = PDF::loadView('back.reportes.pdf_recibos', compact(['recibos','periodo','total_depositos','total_recibos']));
        $pdf->setPaper('letter','landscape');
        return $pdf->stream('recibos_mes.pdf');
            

    }

    public function repo_recibos_periodo(Request $request)
    {
   
        $desde= $request->desde;
        $hasta= $request->hasta;
        $tmp_recibos=Recibo::with('depositos')
        ->where('fecha_recibo', '>=', $desde)
        ->where('fecha_recibo', '<=', $hasta)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        foreach ($tmp_recibos as $recibo) {
            
            foreach ($recibo->depositos as $deposito ) {
                $explode = explode('-',$recibo->concepto);
                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'no_doc' => $recibo->no_doc,
                    'nombre' => $recibo->estudiante->nombre,
                    'fecha_depo' =>$deposito->fecha,
                    'no_depo' =>$deposito->numero,
                    'monto_depo' =>$deposito->monto,
                    'programa' => ucfirst($recibo->estudiante->programa->programa),
                    'mencion'=>  $recibo->estudiante->mencion->mencion,
                    'concepto'=> $recibo->concepto,
                    'status'=> $recibo->status,
                ]);
            }
      
        }
 
        $recibos = $a_recibos;
        $total = array_sum(array_column($a_recibos, 'monto_depo'));
        return view('back.reportes.reporte_recibos_periodo', compact(['recibos','desde', 'hasta', 'total']));
    }

    public function pdf_recibos_periodo(Request $request)
    {
        $desde= $request->desde;
        $hasta= $request->hasta;
        $tmp_recibos=Recibo::with('depositos')
        ->where('fecha_recibo', '>=', $desde)
        ->where('fecha_recibo', '<=', $hasta)
        ->orderBy('no_recibo','DESC')->get();
        $a_recibos=[];
        foreach ($tmp_recibos as $recibo) {
            
            foreach ($recibo->depositos as $deposito ) {
                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'no_doc' => $recibo->no_doc,
                    'nombre' => $recibo->estudiante->nombre,
                    'fecha_depo' =>$deposito->fecha,
                    'no_depo' =>$deposito->numero,
                    'monto_depo' =>$deposito->monto,
                    'programa' => ucwords(strtolower($recibo->estudiante->programa->programa)),
                    'mencion'=>  $recibo->estudiante->mencion->mencion,
                    'concepto'=> ucfirst(strtolower($recibo->concepto)),
                    'status'=> $recibo->status,
                ]);
            }
      
        }
        $recibos = $a_recibos;
        $total = array_sum(array_column($a_recibos, 'monto_depo'));
        $pdf = PDF::loadView('back.reportes.pdf_recibos_periodo', compact(['recibos','desde','hasta','total']));
        $pdf->setPaper('letter','landscape');
        return $pdf->stream('recibos_mes.pdf');
            

    }

    public function explode_concepto(string $concepto)
    {
        $tipo = 'N';
        $mayor=0;
        $explode = explode('-',$concepto);
        return $explode;
    }

    public function busca_constancia($tipo, $tipo_id){
        $constancia='';
        if ($tipo=='OTRO') {
            $constancia='Otro';
        }
        if ($tipo=='ARANCEL') {
            $registro=Arancel::where('id', '=', $tipo_id)->first();
            $constancia=$registro->arancel;


        }
        if ($tipo=='MATRICULA') {
            $registro=Matricula::where('id', '=', $tipo_id)->first();
            $constancia=$registro->nombre;

        }
        $constancia = ucwords(strtolower($constancia));
        return $constancia;

    }

    public function request_multiple(&$recibos, $mes, $ano, &$resumen) {
        $tmp_recibos=Recibo::with('depositos')->with('constancias')
        ->whereMonth('fecha_recibo', $mes)
        ->whereYear('fecha_recibo', $ano)
        ->orderBy('no_recibo','ASC')->get();
        $a_recibos=[];
        $cont_depositos=0;
        $total_depositos=0;
        $total_depositos_ant=0;
        $total_arancel=0;
        $total_arancel_ant=0;
        $total_matricula=0;
        $total_matricula_ant=0;

        $total_otro=0;

        foreach ($tmp_recibos as $recibo) {
            $a_depositos=[];
            $a_constancias=[];
            $total_const=0;
            $total_mes_ant=0;
            if($recibo->status=='VIGENTE'){
                foreach ($recibo->depositos as $deposito ) {
                    $fecha_d = Carbon::parse($deposito->fecha);
                    if($fecha_d->month==$mes){
                        $mes_monto=$deposito->monto;
                        $otro_mes = '';
                        $total_depositos=$total_depositos+$deposito->monto;
                    }else{
                        $mes_monto= '';
                        $otro_mes = $deposito->monto; 
                        $total_mes_ant = $total_mes_ant + $deposito->monto;
                        $total_depositos_ant=$total_depositos_ant+$deposito->monto;
                    }

                    array_push($a_depositos, (object)[
                        'recibo_id' => $recibo->id,
                        'fecha_depo' =>$deposito->fecha,
                        'no_depo' =>$deposito->referencia,
                        'monto_depo' =>$mes_monto,
                        'otro_depo' =>$otro_mes,
                    ]);
                    $cont_depositos++;

                }
                foreach ($recibo->constancias as $constancia ) {
                    $montoArancel='';
                    $montoMatricula='';
                    $montoArancel_ant='';
                    $montoMatricula_ant='';
                    $const_mes_ant = 0;
                    $total_const = $total_const+$constancia->monto_bs;
                    if ($total_mes_ant==0){      
                        if($constancia->tipo=='ARANCEL'){
                            $total_arancel=$total_arancel+$constancia->monto_bs;
                            $montoArancel=$constancia->monto_bs;
                            $montoMatricula='';
                            $montoMatricula_ant='';
                            $montoArancel_ant='';
                             
                        }
                        if(($constancia->tipo=='MATRICULA') or ($constancia->tipo=='OTRO')){
                            $total_matricula=$total_matricula+$constancia->monto_bs;
                            $montoMatricula=$constancia->monto_bs;
                            $montoArancel='';
                            $montoMatricula_ant='';
                            $montoArancel_ant='';
                        }
                    } else {
                        if ($constancia->monto_bs == $total_mes_ant){
                            if($constancia->tipo=='ARANCEL'){
                                $total_arancel_ant=$total_arancel_ant+$constancia->monto_bs;
                                $montoArancel_ant=$constancia->monto_bs;
                                $montoArancel='';
                                $montoMatricula='';
                                $montoMatricula_ant='';
                            }
                            if(($constancia->tipo=='MATRICULA') or ($constancia->tipo=='OTRO') ){
                                $total_matricula_ant=$total_matricula_ant+$constancia->monto_bs;
                                $montoMatricula_ant=$constancia->monto_bs;
                                $montoArancel='';
                                $montoMatricula='';
                                $montoArancel_ant='';
                            }
                            $total_mes_ant=0;

                        } elseif ($constancia->monto_bs > $total_mes_ant) {
                            if($constancia->tipo=='ARANCEL'){
                                $total_arancel_ant=$total_arancel_ant+$total_mes_ant;
                                $total_arancel=$total_arancel+($constancia->monto_bs-$total_mes_ant);
                                $montoArancel_ant=$total_mes_ant;
                                $montoArancel=$constancia->monto_bs-$total_mes_ant;
                                $montoMatricula='';
                                $montoMatricula_ant='';
                            }
                            if(($constancia->tipo=='MATRICULA') or ($constancia->tipo=='OTRO') ){
                                $total_matricula_ant=$total_matricula_ant+$total_mes_ant;
                                $total_matricula=$total_matricula+($constancia->monto_bs-$total_mes_ant);
                                $montoMatricula_ant=$total_mes_ant;
                                $montoMatricula=$constancia->monto_bs-$total_mes_ant;
                                $montoArancel='';
                                $montoArancel_ant='';
                            }
                            $total_mes_ant=0;

                        } elseif ($constancia->monto_bs < $total_mes_ant) {
                            if($constancia->tipo=='ARANCEL'){
                                $total_arancel_ant=$total_arancel_ant+$constancia->monto_bs;
                                $montoArancel_ant=$constancia->monto_bs;
                                $montoMatricula='';
                                $montoMatricula_ant='';
                                $montoArancel='';
                            }
                            if(($constancia->tipo=='MATRICULA') or ($constancia->tipo=='OTRO') ){
                                $total_matricula_ant=$total_matricula_ant+$constancia->monto_bs;
                                $montoMatricula_ant=$constancia->monto_bs;
                                $montoMatricula='';
                                $montoArancel='';
                                $montoArancel_ant='';
                            }
                            $total_mes_ant=$total_mes_ant-$constancia->monto_bs;


                        }

                    }
                    array_push($a_constancias, (object)[
                        'recibo_id' => $recibo->id,
                        'tipo' =>$constancia->tipo,
                        'monto_arancel' =>$montoArancel,
                        'monto_matricula'=>$montoMatricula,
                        'monto_arancel_ant' =>$montoArancel_ant,
                        'monto_matricula_ant'=>$montoMatricula_ant,
                        'constancia' =>$this->busca_constancia($constancia->tipo, $constancia->tipo_id),
                    ]);
                }
                $no_items = max(count($a_constancias),count($a_depositos));
                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'concepto' => $recibo->concepto,
                    'no_doc' => $recibo->no_doc,
                    'nombre' => $recibo->estudiante->nombre,
                    'depositos' => $a_depositos,
                    'constancias' => $a_constancias,
                    'programa' => ucfirst($recibo->estudiante->programa->programa),
                    'total' => $total_const,
                    'no_items' =>$no_items,
    
                ]);
            } else {
                array_push($a_recibos, (object)[
                    'id' => $recibo->id,
                    'no_recibo'=>$recibo->no_recibo,
                    'fecha' => $recibo->fecha_recibo,
                    'no_doc' => '---',
                    'nombre' => 'ANULADO',
                    'concepto' => '',
                    'depositos' => $a_depositos,
                    'constancias' => $a_constancias,
                    'programa' => '',
                    'total' => 0,
                    'no_items' =>0,
    
                ]);
                
            }        
      
        }
        $total = array_sum(array_column($a_recibos, 'total'));
        $recibos = $a_recibos;
        
        array_push($resumen, (object)[
            'recibos'=> count($recibos),
            'depositos'=> $cont_depositos,
            'total_depositos'=>$total_depositos,
            'total_depositos_ant'=>$total_depositos_ant,
            'total_arancel'=>$total_arancel,
            'total_arancel_ant'=>$total_arancel_ant,
            'total_matricula'=>$total_matricula,
            'total_matricula_ant'=>$total_matricula_ant,
            'total_otros'=>$total_otro,
        ]);

        return ;
    }

    public function es_constancia($arancel_id){

        $arancel=Arancel::find($arancel_id);
        if($arancel) {
            if($arancel->constancia==1){
                return true;
            } else {
                return false;
            }

        }else {
            return false;
        }

    }
}
