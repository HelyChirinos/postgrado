<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="{{ public_path('css/bootstrap4.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{ public_path('css/reports.css')}}">
    <title>Recibos-Aranceles&Matricula</title>
    <style>
        table.dataTable thead th, table.dataTable tbody td{
            padding: .1rem;
        }
        .left{
            left: 50px; 
            position: absolute; 
            width: 40%; 
            height:100%;
        }
        .right{
            right: 50px; 
            position: absolute; 
            width: 40%; 
            height:100%;
        }
        .saltopagina{
            page-break-after:always;
        }


    </style>
 
</head>

<body>
    @php
        $decanato = getSetup();
        $logo = 'img/logo'.$decanato->path_logo;
        $nom_decanato = $decanato->decanato;
    @endphp

    <div id="header" >
        <img class="img_header_landscape" src="{{public_path($logo)}}">
        <div class="info_header_landscape">
            <p>Universidad Centroccidental "Lisandro Alvarado"</p>
            @if ($decanato->cod_dec != '00')
                <p>{{$nom_decanato}}</p>
            @endif
            <p>Dirección de Postgrado</p>
        </div>
    </div>
    <div id="footer">
        <div class="container" >
            <div style="width: 100%; font-size:10px; border-top: 1px solid rgb(80, 77, 77); padding-top:0px;" >
                <span style="margin-right: 80%;">Fecha: {{ date('d-m-Y');}} </span>
                 Pag: <span class="pagenum"></span> 
            </div>
        </div>            
    </div>
  
    <div class="container">
        @php
            $sub_total_mas = $resumen->ingresos+$resumen->transito;
            $sub_total_menos = $resumen->comisiones+$resumen->ingreso_anterior;
            $sub_total = $sub_total_mas-$sub_total_menos;

        @endphp
        <div class="row">
            <div class="card mb-2">
                <div class="card-body"  style="padding-top: 0px; padding-bottom: 0px;">
                    <div class="row mb-2 mt-2 ">

                        <table id="sqltable" class="styled-table table-bordered mb-3 mt-0" style="width: 100%">
                            <thead >
                                <tr class="titulo">
                                    <th  colspan="3" style="text-align: center; border-top: solid black; border-left: solid black; border-right: solid black; background-color:#C5D9F1; font-size:16px;" >
                                        CONCILIACION DE LOS INGRESOS RECAUDADOS</th>
                                </tr>
                                <tr class="titulo">
                                    <th  colspan="3" style="text-align: center;  border-left: solid black; border-right: solid black; background-color:#C5D9F1; font-size:16px;" >
                                        PERIODO: {{$periodo}} </th>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">Concepto</th>
                                    <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">Monto (Más)</th>
                                    <th style="text-align: center; border: solid black; background-color:#C5D9F1; font-size:12px;">Monto (Menos)</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: solid black;" >Relación de Ingresos enterados</td>
                                    <td style="border: solid black; text-align: right">{{formatMoney($resumen->ingresos)}} Bs.</td>
                                    <td style="border: solid black;"></td>
                                </tr>

                                <tr>
                                    <td style="border: solid black;"> Depositos No Relacionados(Transito)</td>
                                    <td style="border: solid black; text-align: right">{{formatMoney($resumen->transito)}} Bs.</td>
                                    <td style="border: solid black;"></td>
                                </tr>
                                <tr>
                                    <td style="border: solid black;"> Comisiones</td>
                                    <td style="border: solid black;"></td>
                                    <td style="border: solid black; text-align: right">{{formatMoney($resumen->comisiones)}} Bs.</td>
                                </tr>
                                <tr>
                                    <td style="border-top: solid black; border-left: solid black; border-right: solid black;">Depositos generados en meses anteriores</td>
                                    <td style="border-top: solid black; border-left: solid black; border-right: solid black;"></td>
                                    <td style="border-top: solid black; border-left: solid black; border-right: solid black; text-align: right ">{{formatMoney($resumen->ingreso_anterior)}} Bs.</td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="border-top: 5px solid #5CB85C; border-bottom: solid black; border-left: solid black; border-right: solid black; text-align: right">Subtotal</td>
                                    <td style="border-top: 5px solid #5CB85C; border-bottom: solid black; border-left: solid black; border-right: solid black; text-align: right">{{formatMoney($sub_total_mas)}} Bs.</td>
                                    <td style="border-top: 5px solid #5CB85C; border-bottom: solid black; border-left: solid black; border-right: solid black; text-align: right">{{formatMoney($sub_total_menos)}} Bs.</td>
                                </tr>
                                <tr>
                                    <td style="border: solid black; text-align: right">Total Monto Transferido</td>
                                    <td colspan="2" style="border: solid black; text-align: center; font-weight: bold;">{{formatMoney($sub_total)}} Bs.</td>
                                </tr>

                            </tfoot>    
                        </table> 
                    </div>

                </div>    
            </div> 
        </div>
    </div>
  
    <script>
        window.print();
    </script>
  
</body>
</html>