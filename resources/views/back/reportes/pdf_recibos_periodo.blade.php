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
    <h5 class="text-center">del {{formatFecha($desde)}} hasta el {{formatFecha($hasta)}} </h5>
 
    <div style="margin: 0px 30px 0px 30px">    
        <table id="sqltable" class="table table-bordered table-sm" style="font-size: 12px; border-collapse: collapse; ">
            <thead>
                <tr class="table-active">
                    <th scope="col">Recibo</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Nº Doc.</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Programa</th>
                    <th scope="col"width="25%">Concepto</th>
                    <th scope="col">No.Dep.</th>
                    <th scope="col">Fec.Dep</th>
                    <th scope="col">Monto</th>
                    <th scope="col" width="4%" >Estado </th>
                 </tr>
            </thead>
            <tbody>
                @forelse ($recibos as $item )
                <tr>
                    <td>{{$item->no_recibo}}</td>
                    <td style="white-space: nowrap;">{{formatFecha($item->fecha)}}</td>                            
                    <td>{{$item->no_doc}}</td>
                    <td style="white-space: nowrap;">{{$item->nombre}}</td>
                    <td >{{$item->programa}}</td>
                    <td >{{$item->concepto}}</td>
                    <td>{{$item->no_depo}}</td>
                    <td style="white-space: nowrap;">{{formatFecha($item->fecha_depo)}}</td>
                    <td style="text-align: right;">{{formatMoney($item->monto_depo)}}</td>
                    <td>{{$item->status}}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-3 text-center text-bold">NO HAY RECIBOS REGISTRADOS.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="font-weight-bold">
                <tr>
                    <td colspan="7" class="table-active" style="text-align: right;">TOTAL</td>
                    <td colspan="2" class="table-active" style="text-align: center;">{{formatMoney($total)}} Bs.</td>
                </tr>
            </tfoot>
        </table>
    </div>    


  
</body>
</html>