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
  
    <h5 class="text-center" style="font-size: 16px;" >Resumen de Aranceles </h5>
    <h5 class="text-center" style="font-size: 16px;" >Mes: {{$periodo}} </h5>
 
    <div style="margin: 0px 30px 0px 30px">    
        <table id="sqltable" class="table table-bordered table-sm " style="font-size: 12px; border-collapse: collapse; ">
            <thead >
                <tr>
                    <th scope="col" >Recibo</th>
                    <th scope="col">Fecha</th>
                    <th scope="col" >Nº Doc.</th>
                    <th scope="col">Nombre</th>
                    <th class="text-center" scope="col">Deposito(s)<br> Ref.-Fecha-Monto Bs.</th>
                    <th class="text-center" scope="col">Solicitude(s)<br>Solicitud-Tipo-Monto Bs.</th>
                    <th scope="col">Total</th>
                                      
                 </tr>
            </thead>
            <tbody>
                @forelse ($recibos as $item )
                <tr>
                    <td>{{$item->no_recibo}}</td>
                    <td style="white-space: nowrap;">{{formatFecha($item->fecha)}}</td>                            
                    <td>{{$item->no_doc}}</td>
                    <td>{{$item->nombre}}</td>
                    <td>
                        @foreach ($item->depositos as $deposito)
                          <span>{{$deposito->no_depo}} - {{formatFecha($deposito->fecha_depo)}} - {{formatMoney($deposito->monto_depo)}} Bs. </span> 
                        @endforeach
                    </td>
                    <td>
                        @foreach ($item->constancias as $constancia)
                          <li>{{$constancia->constancia}} - {{$constancia->tipo}} - {{formatMoney($constancia->monto_bs)}} Bs.</li>
                        @endforeach
                    </td>
                    <td> {{formatMoney($item->total)}} Bs.</td>

                </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-3 text-center text-bold">NO HAY RECIBOS REGISTRADOS.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="table-active">
                    <td></td><td></td><td></td><td></td><td></td>
                    <td  style="text-align: right;">TOTAL</td>
                    <td  style="text-align: center;">{{formatMoney($total)}} Bs.</td>
                </tr>
            </tfoot>
        </table>
        

    </div>    
    <div class="saltopagina"></div>
    <div class="row">
        <div class="p-1 mt-2">
            <div class="left" style="margin-left:50px">
                <table id="resumen" class="table datatable table-bordered table-sm " style="font-size: 12px; border-collapse: collapse; padding:.2rem; ">
                    <thead>
                        <tr class="table-active">
                            <th colspan="2" class="text-center">RESUMEN</th>
                        </tr>    
                    </thead>
                    <tbody>
                        <tr>
                            <td>Recibos Emitidos:</td>
                            <td>{{$resumen[0]->recibos}}</td>
                        </tr>
                        <tr>
                            <td>No. de Depositos:</td>
                            <td>{{$resumen[0]->depositos}}</td>
                        </tr>
                        <tr>
                            <td>Monto en Depositos:</td>
                            <td>{{formatMoney($resumen[0]->total_depositos)}} Bs.</td>
                        </tr>
                        <tr>
                            <td>Total en Aranceles:</td>
                            <td>{{formatMoney($resumen[0]->total_arancel)}} Bs.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="right">
                @php $total_const=$resumen[0]->total_arancel; 
                     $total20=$total_const*0.2;    
                @endphp

                <table id="100porcent" class="table datatable table-bordered table-sm" style="font-size: 12px; border-collapse: collapse; padding:.2rem;">
                    <thead>
                        <tr class="table-active">
                            <th colspan="3" class="text-center">TOTAL ARANCELES-100%</th>
                        </tr>
                        <tr class="table-active">
                            <th style="text-align: center"> TOTAL</th>
                            <th style="text-align: center"> 80% </th> 
                            <th style="text-align: center"> 20%</th> 
                        </tr>    

                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center">{{formatMoney($total_const)}} Bs.</td>
                            <td style="text-align: center">{{formatMoney($total_const*0.8)}} Bs.</td>
                            <td style="text-align: center">{{formatMoney($total20)}} Bs.</td>
                        </tr>
                    </tbody>
                </table>
                <table id="20Porcent" class="table datatable table-bordered table-sm" style="font-size: 12px; border-collapse: collapse; padding:.2rem;">
                    <thead>
                        <tr class="table-active">
                            <th colspan="3" class="text-center">TOTAL 20%</th>
                        </tr>
                        <tr class="table-active">
                            <th style="text-align: center"> TOTAL</th>
                            <th style="text-align: center"> 80% </th> 
                            <th style="text-align: center"> 20%</th> 
                        </tr>    

                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center">{{formatMoney($total20)}} Bs.</td>
                            <td style="text-align: center">{{formatMoney($total20*0.8)}} Bs.</td>
                            <td style="text-align: center">{{formatMoney($total20*0.2)}} Bs.</td>
                        </tr>
                    </tbody>
                </table>
            </div>            
        </div>
            
    </div>


  
</body>
</html>