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
            padding: 0rem;
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
  
    <h5 class="text-center" style="font-size: 16px;" >Resumen de Recibos (Arancel y Matrícula) </h5>
    <h5 class="text-center" style="font-size: 16px;" >Mes: {{$periodo}} </h5>
 
    <div style="margin: 0px 30px 0px 30px">    
        <table id="sqltable" class="table table-bordered table-sm " style="font-size: 12px; border-collapse: collapse; ">
            <thead >
                <tr>
                   <th class="no-sort" ></th> 
                   <th class="no-sort"></th>
                   <th class="no-sort"></th>
                   <th class="no-sort"></th>
                   <th class="text-center no-sort" colspan="2">Depositos</th>
                   <th class="text-center no-sort" colspan="2">Solicitudes</th>
                   <th class="text-center no-sort" colspan="2">Facturado</th>
                   <th class="no-sort"></th>
                   <th class="no-sort"></th>
                   <th class="text-center no-sort" colspan="2">Mes Anterior</th>


                </tr>
                <tr>
                    <th scope="col" width="4%">Recibo</th>
                    <th scope="col" width="6%">Fecha</th>
                    <th scope="col" width="6%">Nº Doc</th>
                    <th scope="col">Nombre</th>
                    <th class="text-center" scope="col">Ref.</th>
                    <th class="text-center" scope="col" >Fecha</th>
                    <th style="width:20%" class="text-center" scope="col">Constancia</th>
                    <th class="text-center" scope="col">Tipo</th>
                    <th class="text-center" scope="col">En el Mes</th>
                    <th class="text-center" scope="col">Otro Mes</th>
                    <th class="text-center" scope="col">Arancel</th>
                    <th class="text-center" scope="col">Matrícula</th>
                    <th class="text-center" scope="col">Arancel</th>
                    <th class="text-center"  scope="col">Matrícula</th>
                    
                                      
                 </tr>
            </thead>            
            <tbody style="font-size: 10px;">
                @forelse ($recibos as $item )
                    <tr>
                        <td>{{$item->no_recibo}}</td>
                        <td style="white-space: nowrap;">{{formatFecha($item->fecha)}}</td>                            
                        <td>{{$item->no_doc}}</td>
                        <td style="font-size: 10px;">{{$item->nombre}}</td>
                        <td>{{(count($item->depositos)>0) ? $item->depositos[0]->no_depo : '----' }}</td>
                        <td style="white-space: nowrap;">{{(count($item->depositos)>0) ? formatFecha($item->depositos[0]->fecha_depo):'----'}}</td>

                        <td>{{(count($item->constancias)>0) ? $item->constancias[0]->constancia : '----'}}</td>
                        <td >{{(count($item->constancias)>0) ? $item->constancias[0]->tipo : '----'}}</td>

                        <td style="text-align: right;"> {{(count($item->depositos)>0) ? formatMoney($item->depositos[0]->monto_depo) : '----'}} </td>
                        <td style="text-align: right;">{{(count($item->depositos)>0) ? formatMoney($item->depositos[0]->otro_depo) : '----'}} </td>

                        <td style="text-align: right;">{{(count($item->constancias)>0) ? formatMoney($item->constancias[0]->monto_arancel) : '----'}}</td>
                        <td style="text-align: right;">{{(count($item->constancias)>0) ? formatMoney($item->constancias[0]->monto_matricula) : '----'}}</td>
                        <td style="text-align: right;">{{(count($item->constancias)>0) ? formatMoney($item->constancias[0]->monto_arancel_ant) : '----'}}</td>
                        <td style="text-align: right;">{{(count($item->constancias)>0) ? formatMoney($item->constancias[0]->monto_matricula_ant) : '----'}}</td>

                    </tr>
                    @if (($item->no_items>1) || (count($item->constancias)> 0) || (count($item->depositos)>0))
                        @php
                            $i = 1;
                        @endphp
                        @for ( $i=1; $i<$item->no_items;$i++)
                            <tr>
                                <td></td><td></td><td></td><td></td>
                                @if (count($item->depositos)>=$i+1)
                                    <td>{{$item->depositos[$i]->no_depo}}</td>
                                    <td>{{formatFecha($item->depositos[$i]->fecha_depo)}}</td>
                                @else
                                    <td></td><td></td>       
                                @endif
                                @if (count($item->constancias)>=$i+1)
                                    <td >{{$item->constancias[$i]->constancia}}</td>
                                    <td>{{$item->constancias[$i]->tipo}}</td>
                                @else
                                    <td></td><td></td>       
                                @endif
                                @if (count($item->depositos)>=$i+1)
                                    <td style="text-align: right;">{{formatMoney($item->depositos[$i]->monto_depo)}}</td>
                                    <td style="text-align: right;">{{formatMoney($item->depositos[$i]->otro_depo)}}</td>
                                @else
                                    <td></td><td></td>       
                                @endif
                                @if (count($item->constancias)>=$i+1)
                                    <td style="text-align: right;">{{formatMoney($item->constancias[$i]->monto_arancel)}}</td>
                                    <td style="text-align: right;">{{formatMoney($item->constancias[$i]->monto_matricula)}}</td>
                                    <td style="text-align: right;">{{formatMoney($item->constancias[$i]->monto_arancel_ant)}}</td>
                                    <td style="text-align: right;">{{formatMoney($item->constancias[$i]->monto_matricula_ant)}}</td>

                                @else
                                    <td></td><td></td><td></td><td></td>       
                                @endif
                            </tr>
                        @endfor

                    @endif

                @empty
                    <tr>
                        <td colspan="11" class="p-3 text-center text-bold">NO HAY RECIBOS REGISTRADOS.</td>
                    </tr>
                @endforelse

            </tbody>

            <tfoot>
                <tr class="table-active">
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td>

                    <td  style="text-align: right;">TOTALES</td>
                    <td  style="text-align: right;">{{formatMoney($resumen[0]->total_depositos)}} Bs.</td>
                    <td  style="text-align: right;">{{formatMoney($resumen[0]->total_depositos_ant)}} Bs.</td>
                    <td  style="text-align: right;">{{formatMoney($resumen[0]->total_arancel)}} Bs.</td>
                    <td  style="text-align: right;">{{formatMoney($resumen[0]->total_matricula)}} Bs.</td>
                    <td  style="text-align: right;">{{formatMoney($resumen[0]->total_arancel_ant)}} Bs.</td>
                    <td  style="text-align: right;">{{formatMoney($resumen[0]->total_matricula_ant)}} Bs.</td>

                </tr>
            </tfoot>
    
        </table>
        

    </div> 
    <div class="saltopagina"></div>   
    <div class="row ">
        <div class="p-1 mt-2" >
            <div class="left" style="margin-left: 50px">
                <table id="resumen" class="table datatable table-bordered table-sm" style="font-size: 12px; border-collapse: collapse; padding:.2rem; ">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center">RESUMEN</th>
                        </tr>    
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="2" style="text-align: center;"> Total Facturado:</td>
                            <td>En el Mes</td>
                            <td>{{formatMoney($resumen[0]->total_depositos)}} Bs.</td>
                        </tr>
                        <tr>
                            <td>Otro Mes:</td>
                            <td>{{formatMoney($resumen[0]->total_depositos_ant)}} Bs.</td>
                        </tr>

                        <tr>
                            <td rowspan="2" style="text-align: center;">Total en Aranceles:</td>
                            <td>En el Mes</td>
                            <td>{{formatMoney($resumen[0]->total_arancel)}} Bs.</td>
                        </tr>
                        <tr>
                            <td>Otro Mes:</td>
                            <td>{{formatMoney($resumen[0]->total_arancel_ant)}} Bs.</td>
                        </tr>

                        <tr>
                            <td rowspan="2" style="text-align: center;">Total en Matrículas:</td>
                            <td>En el Mes</td>
                            <td>{{formatMoney($resumen[0]->total_matricula)}} Bs.</td>
                        </tr>
                        <tr>
                            <td>Otro Mes:</td>
                            <td>{{formatMoney($resumen[0]->total_matricula_ant)}} Bs.</td>
                        </tr>


                    </tbody>
                </table>    
            </div>
            <div class="right" style="margin-left: 150px;">

                <table id="100porcent" class="table datatable table-bordered table-sm" style="font-size: 12px; border-collapse: collapse; padding:.2rem;">
                    <thead>
                        <tr>
                            <th colspan="4" class="text-center">DISTRIBUCIÓN {{$periodo}}</th>

                        </tr>
                        <tr> 
                            <th colspan="3" class="text-center"> Recaudación del Mes</th>
                            <th style="text-align: right;">{{formatMoney($resumen[0]->total_depositos)}} Bs.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Aranceles</th>
                            <th style="text-align: center">Facturado</th>
                            <th style="text-align: center">80% </th>
                            <th style="text-align: center">20% </th>
                        </tr>
                        <tr>
                            <td style="text-align: right;">{{formatMoney($resumen[0]->total_arancel)}} Bs.</td>
                            <td style="text-align: right;">{{formatMoney($resumen[0]->total_arancel*0.8)}} Bs.</td>
                            <td style="text-align: right;">{{formatMoney($resumen[0]->total_arancel*0.2)}} Bs.</td>
                        </tr>
                        <tr>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Matrículas</th>
                            <th style="text-align: center">Facturado</th>
                            <th style="text-align: center">80% </th>
                            <th style="text-align: center">20% </th>
                        </tr>
                        <tr>
                            <td style="text-align: right;">{{formatMoney($resumen[0]->total_matricula)}} Bs.</td>
                            <td style="text-align: right;">{{formatMoney($resumen[0]->total_matricula*0.8)}} Bs.</td>
                            <td style="text-align: right;">{{formatMoney($resumen[0]->total_matricula*0.2)}} Bs.</td>
                        </tr>

                    </tbody>
                </table>
                <table class="table datatable table-bordered table-sm" style="font-size: 12px; border-collapse: collapse; padding:.2rem;">    
                    <thead>
                        <tr> 
                            <th colspan="3" class="text-center"> Recaudación Otro Mes</th>
                            <th style="text-align: right;">{{formatMoney($resumen[0]->total_depositos_ant)}} Bs.</th>
                        </tr>
                        <tbody>
                            <tr>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Aranceles</th>
                                <th style="text-align: center">Facturado</th>
                                <th style="text-align: center">80% </th>
                                <th style="text-align: center">20% </th>
                            </tr>
                            <tr>
                                <td style="text-align: right;">{{formatMoney($resumen[0]->total_arancel_ant)}} Bs.</td>
                                <td style="text-align: right;">{{formatMoney($resumen[0]->total_arancel_ant*0.8)}} Bs.</td>
                                <td style="text-align: right;">{{formatMoney($resumen[0]->total_arancel_ant*0.2)}} Bs.</td>
                            </tr>
                            <tr>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Matrículas</th>
                                <th style="text-align: center">Facturado</th>
                                <th style="text-align: center">80% </th>
                                <th style="text-align: center">20% </th>
                            </tr>
                            <tr>
                                <td style="text-align: right;">{{formatMoney($resumen[0]->total_matricula_ant)}} Bs.</td>
                                <td style="text-align: right;">{{formatMoney($resumen[0]->total_matricula_ant*0.8)}} Bs.</td>
                                <td style="text-align: right;">{{formatMoney($resumen[0]->total_matricula_ant*0.2)}} Bs.</td>
                            </tr>

                        </tbody>
                    </thead>
                        
                </table>
            </div>

        </div>
            
    </div>


  
</body>
</html>