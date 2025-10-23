@extends('layouts.back')

@section('title')
    &vert; Bancos-Principal 
@endsection


@section('content')
    <style>
        @media print {
             /* All your print styles go here */
            #header,
            #footer,
            #botones,
            #nav {
                display: none !important;
            }
}
    </style>
    <div class="container">
        @php
            $sub_total_mas = $resumen->ingresos+$resumen->transito+$resumen->saldo_anterior;
            $sub_total_menos = $resumen->comisiones+$resumen->ingreso_anterior+$resumen->transferencias;
            $sub_total = $sub_total_mas-$sub_total_menos;

        @endphp
        <div class="row">
            <div class="card mb-2">
                <div class="card-body"  style="padding-top: 0px; padding-bottom: 0px;">
                    <div id="botones" class="d-flex justify-content-between p-1 mt-3">
                        <div id="ToolbarLeft"></div>
                        <div id="ToolbarCenter">
                            <div class=" dt-buttons " role="group" aria-label="Second group">
                                <button type="button" class="btn btn-sm btn-primary" onclick="showExcel()">Excel</button>
                                <button type="button" class="btn btn-sm btn-success" onclick="showPDF()">PDF</button>
                                <button type="button" class="btn btn-sm btn-secondary" onclick="printer()">Printer </button>
                              </div>                            
                        </div>
                        <div id="ToolbarRight"></div>
                    </div>

                    <div class="row mb-2 mt-2">
                        <div class="col-2"></div>
                        <div class="col-8">

                            <table id="sqltable" class="styled-table table-bordered mb-3 mt-0" style="width: 100%">
                                <thead >
                                    <tr class="titulo">
                                        <td class="text-center no-select no-export fs-5" colspan="8" data-dt-order="disable">
                                            CONCILIACION DE LOS INGRESOS RECAUDADOS <br> PERIODO: {{$periodo}} </td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Concepto</th>
                                        <th scope="col">Monto (Más)</th>
                                        <th scope="col">Monto (Menos)</th>
    
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Saldo Anterior</td>
                                        <td style="text-align: right">{{formatMoney($resumen->saldo_anterior)}} Bs.</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Relación de Ingresos enterados</td>
                                        <td style="text-align: right">{{formatMoney($resumen->ingresos)}} Bs.</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td> Depositos No Relacionados(Transito)</td>
                                        <td style="text-align: right">{{formatMoney($resumen->transito)}} Bs.</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td> Comisiones</td>
                                        <td></td>
                                        <td style="text-align: right">{{formatMoney($resumen->comisiones)}} Bs.</td>
                                    </tr>
                                    <tr>
                                        <td>Depositos generados en meses anteriores</td>
                                        <td></td>
                                        <td style="text-align: right">{{formatMoney($resumen->ingreso_anterior)}} Bs.</td>
                                    </tr>
                                    <tr>
                                        <td>Otros Cargos</td>
                                        <td></td>
                                        <td style="text-align: right">{{formatMoney($resumen->transferencias)}} Bs.</td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="text-align: right">Subtotal</td>
                                        <td style="text-align: right">{{formatMoney($sub_total_mas)}} Bs.</td>
                                        <td style="text-align: right">{{formatMoney($sub_total_menos)}} Bs.</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">Total Monto Transferido</td>
                                        <td colspan="2" style="text-align: right">{{formatMoney($sub_total)}} Bs.</td>
                                    </tr>

                                </tfoot>    
                            </table> 
                        </div>         
                        <div class="col-2"></div>
                   
                    </div>

                </div>    
            </div> 
        </div>
    </div>

<script>
  function showExcel(){
        let resumen ="{{$resumen->id}}";
        let periodo ="{{$periodo}}";
        let str = periodo.split("-");
        console.log(str[0]);
        let mes = str[0];
        let ano = str[1];  
        periodo = ano+'-'+mesAInt(mes);
        let url = '{{ route('back.excel.FullRecibos')}}'+'?periodo='+periodo
        document.location.href=url;               
        window.location = url;
  }
  function showPDF(){
        let resumen ="{{$resumen->id}}";
        let periodo ="{{$periodo}}";
        let url = "{{ route('back.bancos.showPdf') }}";
        url = url+'?periodo='+periodo+'&resumen='+resumen; 
        let newTab = document.createElement('a');
        newTab.href = url;
        newTab.target = "_blank";
        newTab.click();

    }
    function printer (win) {
        window.print();
    }

    function mesAInt(mesEscrito) {
        const meses = {
            "Enero": 1,
            "Febrero": 2,
            "Marzo": 3,
            "Abril": 4,
            "Mayo": 5,
            "Junio": 6,
            "Julio": 7,
            "Agosto": 8,
            "Septiembre": 9,
            "Octubre": 10,
            "Noviembre": 11,
            "Diciembre": 12
        };
        mesEscrito = mesEscrito.trim(); // Eliminar espacios al inicio y al final
        return meses[mesEscrito] || null; // Devuelve null si no se encuentra
    }


</script>

@endsection




