<div class="container">

    <table id="sqltable" class="table dataTable" >
        <thead >
            <tr >
                <th colspan="11" style="font-size: 14px; text-align: center; font-weight: bold;"> Recibos: {{$periodo}} </th> 
            </tr>
            <tr>
                <th ></th> 
                <th ></th>
                <th ></th>
                <th ></th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1;" colspan="2">Depositos</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1;" colspan="2">Solicitudes</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1;" colspan="2">Facturado</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1;" colspan="2">En el Mes</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1;" colspan="2">Mes Anterior</th>
            </tr>
            <tr>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Recibo</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Fecha</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Nº Doc.</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Nombre</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Ref.</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Fecha</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Constancia</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Tipo</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">En el Mes</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Otro Mes</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Arancel</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Matrícula</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Arancel</th>
                <th style="text-align: center; border: solid black; background-color:#C5D9F1; ">Matrícula</th>
                
                                  
            </tr>

        </thead>
        <tbody>
            @forelse ($recibos as $item )
                <tr>
                    <td style="border-top: solid;border-left: solid; border-right: solid;">{{$item->no_recibo}}</td>
                    <td style="border-top: solid;border-left: solid; border-right: solid;">{{formatFecha($item->fecha)}}</td>                            
                    <td style="border-top: solid;border-left: solid; border-right: solid;">{{$item->no_doc}}</td>
                    <td style="border-top: solid;border-left: solid; border-right: solid;">{{$item->nombre}}</td>
                    <td style="border-top: solid;border-left: solid; border-right: solid;">{{(count($item->depositos)>0) ? $item->depositos[0]->no_depo : '----' }}</td>
                    <td style="border-top: solid;border-left: solid; border-right: solid;">{{(count($item->depositos)>0) ? formatFecha($item->depositos[0]->fecha_depo):'----'}}</td>

                    <td style="border-top: solid;border-left: solid; border-right: solid;" >{{(count($item->constancias)>0) ? $item->constancias[0]->constancia : '----'}}</td>
                    <td style="border-top: solid;border-left: solid; border-right: solid;" >{{(count($item->constancias)>0) ? $item->constancias[0]->tipo : '----'}}</td>

                    <td style="text-align: right; border-top: solid;border-left: solid; border-right: solid;" > {{(count($item->depositos)>0) ? $item->depositos[0]->monto_depo : '----'}} </td>
                    <td style="text-align: right; border-top: solid;border-left: solid; border-right: solid;">{{(count($item->depositos)>0) ? $item->depositos[0]->otro_depo : '----'}} </td>

                    <td style="text-align: right; border-top: solid;border-left: solid; border-right: solid;">{{(count($item->constancias)>0) ? $item->constancias[0]->monto_arancel : '----'}}</td>
                    <td style="text-align: right; border-top: solid;border-left: solid; border-right: solid;">{{(count($item->constancias)>0) ? $item->constancias[0]->monto_matricula : '----'}}</td>
                    <td style="text-align: right; border-top: solid;border-left: solid; border-right: solid;">{{(count($item->constancias)>0) ? $item->constancias[0]->monto_arancel_ant : '----'}}</td>
                    <td style="text-align: right; border-top: solid;border-left: solid; border-right: solid;">{{(count($item->constancias)>0) ? $item->constancias[0]->monto_matricula_ant : '----'}}</td>

                </tr>
                @if (($item->no_items>1) || (count($item->constancias)> 0) || (count($item->depositos)>0))
                    @php
                        $i = 1;
                    @endphp
                    @for ( $i=1; $i<$item->no_items;$i++)
                        <tr>
                            <td style="border-left: solid; border-right: solid;"></td><td style="border-left: solid; border-right: solid;"></td><td style="border-left: solid; border-right: solid;"></td><td style="border-left: solid; border-right: solid;"></td>
                            @if (count($item->depositos)>=$i+1)
                                <td style="border-left: solid; border-right: solid;">{{$item->depositos[$i]->no_depo}}</td>
                                <td style="border-left: solid; border-right: solid;">{{formatFecha($item->depositos[$i]->fecha_depo)}}</td>
                            @else
                                <td style="border-left: solid; border-right: solid;"></td><td style="border-left: solid; border-right: solid;"></td>       
                            @endif
                            @if (count($item->constancias)>=$i+1)
                                <td style="border-left: solid; border-right: solid;">{{$item->constancias[$i]->constancia}}</td>
                                <td style="border-left: solid; border-right: solid;">{{$item->constancias[$i]->tipo}}</td>
                            @else
                                <td style="border-left: solid; border-right: solid;"></td><td style="border-left: solid; border-right: solid;"></td>       
                            @endif
                            @if (count($item->depositos)>=$i+1)
                                <td style="text-align: right; border-left: solid; border-right: solid;">{{$item->depositos[$i]->monto_depo}}</td>
                                <td style="text-align: right; border-left: solid; border-right: solid;">{{$item->depositos[$i]->otro_depo}}</td>
                            @else
                                <td style="border-left: solid; border-right: solid;"></td><td style="border-left: solid; border-right: solid;"></td>       
                            @endif
                            @if (count($item->constancias)>=$i+1)
                                <td style="text-align: right;">{{$item->constancias[$i]->monto_arancel}}</td>
                                <td style="text-align: right; border-left: solid; border-right: solid;">{{$item->constancias[$i]->monto_matricula}}</td>
                                <td style="text-align: right; border-left: solid; border-right: solid;">{{$item->constancias[$i]->monto_arancel_ant}}</td>
                                <td style="text-align: right; border-left: solid; border-right: solid;">{{$item->constancias[$i]->monto_matricula_ant}}</td>

                            @else
                                <td style="border-left: solid; border-right: solid;"></td><td style="border-left: solid; border-right: solid;"></td><td style="border-left: solid; border-right: solid;"></td><td style="border-left: solid; border-right: solid;"></td>       
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
                <td style="border: solid;"></td><td style="border: solid;"></td><td style="border: solid;"></td><td style="border: solid;"></td><td style="border: solid;"></td><td style="border: solid;"></td><td style="border: solid;"></td>

                <td  style="text-align: right; border: solid;">TOTALES</td>
                <td  style="text-align: right; border: solid;">{{$resumen[0]->total_depositos}}</td>
                <td  style="text-align: right; border: solid;">{{$resumen[0]->total_depositos_ant}}</td>
                <td  style="text-align: right; border: solid;">{{$resumen[0]->total_arancel}}</td>
                <td  style="text-align: right; border: solid;">{{$resumen[0]->total_matricula}}</td>
                <td  style="text-align: right; border: solid;">{{$resumen[0]->total_arancel_ant}}</td>
                <td  style="text-align: right; border: solid;">{{$resumen[0]->total_matricula_ant}}</td>

            </tr>        
        </tfoot>
    </table>
</div>
<div class="row"></div>
<div class="row"></div>
<div class="row">
    <div class="d-flex justify-content-between p-1 mt-2">
        <div id="barLeft"></div>
        <div id="barCenterleft">
            <table id="resumen" class="table table-bordered table-striped datatable" style="width: 100%">
                <thead>
                    
                    <tr>
                        <th></th><th></th><th></th><th></th><th></th><th></th>
                        <th colspan="3" style="text-align: center; border: solid; background-color:#C5D9F1;">RESUMEN</th>
                    </tr>    
                </thead>
                <tbody>
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td>
                        <td rowspan="2" style="text-align: center; vertical-align: middle; border: solid;"> 
                            Total Facturado: {{formatMoney($resumen[0]->total_depositos+$resumen[0]->total_depositos_ant)}} Bs. </td>
                        <td style="text-align: center; border: solid;">En el Mes</td>
                        <td style="text-align: center; border: solid;">{{$resumen[0]->total_depositos}}</td>
                    </tr>
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td>
                        <td style="text-align: center; border: solid;">Otro Mes:</td>
                        <td style="text-align: center; border: solid;">{{$resumen[0]->total_depositos_ant}}</td>
                    </tr>

                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td>
                        <td rowspan="2" style="text-align: center; vertical-align: middle; border: solid;">
                            Total en Aranceles: {{formatMoney($resumen[0]->total_arancel + $resumen[0]->total_arancel_ant)}} Bs.</td>
                        <td style="text-align: center; border: solid;">En el Mes</td>
                        <td style="text-align: center; border: solid;">{{$resumen[0]->total_arancel}}</td>
                    </tr>
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td>
                        <td style="text-align: center; border: solid;">Otro Mes:</td>
                        <td style="text-align: center; border: solid;">{{$resumen[0]->total_arancel_ant}}</td>
                    </tr>

                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td>
                        <td rowspan="2" style="text-align: center; vertical-align: middle; border: solid;">
                            Total en Matrículas: {{formatMoney($resumen[0]->total_matricula+$resumen[0]->total_matricula_ant)}} Bs.</td>
                        <td style="text-align: center; border: solid;">En el Mes</td>
                        <td style="text-align: center; border: solid;">{{$resumen[0]->total_matricula}} </td>
                    </tr>
                    <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td>
                        <td style="text-align: center; border: solid;">Otro Mes:</td>
                        <td style="text-align: center; border: solid;">{{$resumen[0]->total_matricula_ant}}</td>
                    </tr>


                </tbody>
            </table>
        </div>
     </div>
</div>




