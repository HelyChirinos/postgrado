<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="{{ public_path('css/bootstrap4.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{ public_path('css/reports.css')}}">
    <title>Recibo-Mes</title>
 
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
  
    <h5 class="text-center">Reporte de Recibos</h5>
    <h5 class="text-center">Mes: {{$periodo}} </h5>
 
    <div style="margin: 0px 30px 0px 30px">    
        <table id="sqltable" class="table table-bordered table-sm" style="font-size: 12px; border-collapse: collapse; ">
            <thead>
                
                <tr class="table-active">
                    <th scope="col" width="4%">Recibo</th>
                    <th scope="col" width="6%">Fecha</th>
                    <th scope="col" width="6%">Nº Doc.</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Programa</th>
                    <th scope="col" width="25%">Concepto</th>
                    <th scope="col">No.Dep.</th>
                    <th scope="col">Fec.Dep</th>
                    <th scope="col">Monto Depo. </th>
                    <th scope="col">Total Recibo</th>
               </tr>
            </thead>
            <tbody style="font-size: 10px;">
                @forelse ($recibos as $item )

                    @php
                        $total = count($item->depositos);
                    @endphp
                    @for ($i=0; $i<$total;$i++)
                        @if($i == 0)
                            <tr>
                                <td>{{$item->no_recibo}}</td>
                                <td style="white-space: nowrap;">{{formatFecha($item->fecha)}}</td>                            
                                <td>{{$item->no_doc}}</td>
                                <td style="white-space: nowrap;">{{$item->nombre}}</td>
                                <td>{{$item->programa}}</td>
                                <td>{{$item->concepto}}</td>
                                <td>{{$item->depositos[0]->no_depo}}</td>
                                <td style="white-space: nowrap;" >{{formatFecha($item->depositos[0]->fecha_depo)}}</td>
                                <td style="text-align: right">{{($item->depositos[0]->monto_depo=='') ? formatMoney($item->depositos[0]->otro_depo) : formatMoney($item->depositos[0]->monto_depo) }} Bs.</td>
                                <td style="text-align: right">{{formatMoney($item->total)}} Bs.</td>
                            </tr>
                        @else    
                            <tr>
                                <td></td>
                                <td></td>                            
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$item->depositos[$i]->no_depo}}</td>
                                <td style="white-space: nowrap;">{{formatFecha($item->depositos[$i]->fecha_depo)}}</td>
                                <td style="text-align: right">{{($item->depositos[$i]->monto_depo=='') ? formatMoney($item->depositos[$i]->otro_depo) : formatMoney($item->depositos[$i]->monto_depo) }} Bs.</td>
                                <td></td>
                            </tr>

                        @endif    
                    @endfor
                @empty
                    <tr>
                        <td colspan="9" class="p-3 text-center text-bold">NO HAY RECIBOS REGISTRADOS.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot style="font-size: 10px;" class="font-weight-bold">
                <tr class="table-active">
                    <td></td><td><td><td><td><td></td></td></td></td></td><td></td>
                    <td   style="text-align: right;">TOTAL</td>
                    <td    style="text-align: center;">{{ formatMoney($total_depositos)}} Bs.</td>
                    <td    style="text-align: center;">{{ formatMoney($total_recibos)}} Bs.</td>

                </tr>
</tfoot>
        </table>
    </div>    


  
</body>
</html>