@extends('layouts.back')

@section('title')
    &vert; Recibos
@endsection

@section('content')
    <div class="card mb-2">
        <div class="card-header d-print-none">
            <div class="row">
                <div class="col-11 text-center fs-5">Facturacíon: {{$periodo}}</div>

                <div class="col fs-5 text-end">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="d-flex justify-content-between p-1 mt-2">
                <div id="ToolbarLeft"></div>
                <div id="ToolbarCenter"></div>
                <div id="ToolbarRight"></div>
            </div>
            <div class="row">
            <div class="col">
                <table id="sqltable" class="table table-bordered table-striped table-sm table-hover dataTable" style="width: 80%">
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
                            <th scope="col" width="6%">Nº Doc.</th>
                            <th scope="col">Nombre</th>
                            <th class="text-center" scope="col">Ref.</th>
                            <th class="text-center" scope="col" >Fecha</th>
                            <th class="text-center" scope="col">Constancia</th>
                            <th class="text-center" scope="col">Tipo</th>
                            <th class="text-center" scope="col">En el Mes</th>
                            <th class="text-center" scope="col">Otro Mes</th>
                            <th class="text-center" scope="col">Arancel</th>
                            <th class="text-center" scope="col">Matrícula</th>
                            <th class="text-center" scope="col">Arancel</th>
                            <th class="text-center"  scope="col">Matrícula</th>
                            
                                              
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recibos as $item )
                            <tr>
                                <td>{{$item->no_recibo}}</td>
                                <td>{{formatFecha($item->fecha)}}</td>                            
                                <td>{{$item->no_doc}}</td>
                                <td>{{$item->nombre}}</td>
                                <td>{{(count($item->depositos)>0) ? $item->depositos[0]->no_depo : '----' }}</td>
                                <td>{{(count($item->depositos)>0) ? formatFecha($item->depositos[0]->fecha_depo):'----'}}</td>

                                <td>{{(count($item->constancias)>0) ? $item->constancias[0]->constancia : '----'}}</td>
                                <td>{{(count($item->constancias)>0) ? $item->constancias[0]->tipo : '----'}}</td>

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
                                            <td>{{$item->constancias[$i]->constancia}}</td>
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
            @php $total_const=$resumen[0]->total_arancel+$resumen[0]->total_matricula; 
                $total20=$total_const*0.2;    
            @endphp

            <div class="row">
                <div class="d-flex justify-content-between p-1 mt-2">
                    <div id="barLeft"></div>
                    <div id="barCenterleft">
                        <table id="resumen" class="table table-bordered table-striped datatable" style="width: 100%">
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
                    <div id="barCentrRight">
                        <table id="100porcent" class="table table-bordered table-striped datatable" style="width: 100%; margin-bottom: 30px;">
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
                        <table class="table table-bordered table-striped datatable" style="width: 100%; margin-bottom: 30px;">    
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
                    <div id="barRight"></div>
                 </div>
            </div>
        </div>
        </div>
    </div>
@endsection



@push('styles')

<style>
    table.dataTable thead {
        background-color: rgb(74, 190, 123);
        color:azure;
        text-align: center;
    }
    .page-item.active .page-link {
        background-color: rgb(74, 190, 123) !important;
        color: azure !important;
        /* border: 1px solid black; */
    }
    .page-link {
        color: black !important;
    }   


</style>

@endpush

@push('scripts')
<script type="module" src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.min.js"></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.templates.min.js"></script>
<script type="module">
        let periodo = "{{$pdf_periodo}}";
        console.log(periodo);
        let dtButtonsCenter = [];
        let dtButtonsRight = [];
        /* ------------------------------------------------------------------------ */
        let excelButton = {
            className: 'btn-primary',
            text: 'Excel',
            titleAttr: 'Exportar a Excel',
            action: function(e, dt, node, config) {
                dt.state.clear();
                let url = '{{ route('back.excel.FullRecibos')}}'+'?periodo='+periodo
                document.location.href = url;
            }
         }
        dtButtonsCenter.push(excelButton)

        let pdfButton = {
            className: 'btn-success',
            text: 'PDF',
            titleAttr: 'Cear PDF',
            action: function(e, dt, node, config) {
                dt.state.clear();
                let url='{{ route('back.pdf.recibos_completo')}}';
                let newTab = document.createElement('a');
                newTab.href = url+'?periodo='+periodo;
                console.log (newTab.href);
                newTab.target = "_blank";
                newTab.click();

            }
        }
        dtButtonsCenter.push(pdfButton)

        let printButton = {
            extend: 'print',
            className: 'btn-secondary',
            text: 'Printer',
            titleAttr: 'Imptimir',
            exportOptions: {
                columns: ':visible:not(.no-export)',
                orthogonal: "myExport",
            },
            //autoPrint: false,
            orientation: 'landscape',
            customize: function (win) {
                // ------------------------------------------------ //
                // print in landscape mode, because it seems        //
                // orientation: 'landscape'                         //
                // is not working on the print button               //
                // ------------------------------------------------ //
                let css = '@page { size: landscape; }',
                    head = win.document.head || win.document.getElementsByTagName('head')[0],
                    style = win.document.createElement('style');

                style.type = 'text/css';
                style.media = 'print';

                if (style.styleSheet) {
                    style.styleSheet.cssText = css;
                } else {
                    style.appendChild(win.document.createTextNode(css));
                }

                head.appendChild(style);
                // ------------------------------------------------ //
                // formatting                                       //
                // ------------------------------------------------ //
                $(win.document.body).css('padding-top', '0.5rem');
                $(win.document.body).find('h1').css('font-size', '12px');
                $(win.document.body).find('table')
                    .addClass('display')
                    .addClass('compact')
                    .css('font-size', '10px');
                // ------------------------------------------------ //
            },
             
        }
        dtButtonsCenter.push(printButton)
        let BackButton = {
            className: 'btn-warning',
            text: "<i class='bi bi-box-arrow-left'</i>",
            titleAttr: 'Regrasar a Reportes',
            action: function(e, dt, node, config) {
                dt.state.clear();

                document.location.href = '{{ route('back.reportes.index')}}';
            }
        }
        dtButtonsRight.push(BackButton)


        /* ------------------------------------------------------------------------ */

        let dtOverrideGlobals = {
            buttons: [       
                {
                },
            ],
            serverSide: false,
            retrieve: false,
            paging:false,
            layout: null,
            lengthMenu: null,
            ordering: false,
            layout: {
                top2Start: null,
                top2End: null,    
                topEnd: 'search',
                topStart: 'buttons',
                topEnd: 'search',    
                bottomStart: 'info',
                bottomEnd: 'paging'
            },    
            select: false,
            language: {
                url: "{{ asset('json/datatables/i18n/es-ES.json') }}",
                paginate: {
                    next: '<i class="fa fa-forward" title="próximo"></i>',
                    previous: '<i class="fa fa-backward" title="anterior"></i>',
                    first: '<i class="fa fa-step-backward" title="primero"></i>',
                    last: '<i class="fa fa-step-forward" title="último"></i>',
                }

            },
  
        };
    /* ------------------------------------------- */
      let oTable = $('#sqltable').DataTable(dtOverrideGlobals);
    /* ------------------------------------------------------------------------ */
    new $.fn.dataTable.Buttons(oTable, {
            name: 'BtnGroupCenter',
            buttons: dtButtonsCenter
    });               
    new $.fn.dataTable.Buttons(oTable, {
            name: 'BtnGroupRight',
            buttons: dtButtonsRight
        });
        

        oTable.buttons('BtnGroupCenter', null).containers().appendTo('#ToolbarCenter');
        oTable.buttons('BtnGroupRight', null).containers().appendTo('#ToolbarRight');

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" type="text/javascript"></script>


@endpush






