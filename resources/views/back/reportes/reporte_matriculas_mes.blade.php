@extends('layouts.back')

@section('title')
    &vert; Recibos-Aranceles
@endsection

@section('content')
    <div class="card mb-2">
        <div class="card-header d-print-none">
            <div class="row">
                <div class="col-11 text-center fs-5">Matrículas: {{$periodo}}</div>

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
                            <th scope="col" width="4%">Recibo</th>
                            <th scope="col" width="6%">Fecha</th>
                            <th scope="col" width="6%">Nº Doc.</th>
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
                            <td>{{formatFecha($item->fecha)}}</td>                            
                            <td>{{$item->no_doc}}</td>
                            <td>{{$item->nombre}}</td>
                            <td>
                                @foreach ($item->depositos as $deposito)
                                  <span>{{$deposito->no_depo}} - {{formatFecha($deposito->fecha_depo)}} - {{formatMoney($deposito->monto_depo)}} Bs. </span> 
                                @endforeach
                            </td>
                            <td>
                                @foreach ($item->constancias as $constancia)
                                  <li>{{$constancia->constancia}} - {{$constancia->tipo}} - {{formatMoney($constancia->monto_bs)}}</li>
                                @endforeach
                            </td>
                            <td> {{formatMoney($item->total)}}</td>

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
            <div class="row">
                <div class="d-flex justify-content-between p-1 mt-2">
                    <div id="barLeft"></div>
                    <div id="barCenterleft">
                        <table id="resumen" class="table table-bordered table-striped datatable" style="width: 100%">
                            <thead>
                                <tr>
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
                                    <td>Total en Matrículas:</td>
                                    <td>{{formatMoney($resumen[0]->total_matricula)}} Bs.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="barCentrRight">
                        @php $total_const=$resumen[0]->total_matricula; 
                             $total20=$total_const*0.2;    
                        @endphp

                        <table id="100porcent" class="table table-bordered table-striped datatable" style="width: 100%; margin-bottom: 30px;">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center">TOTAL MATRICULAS-100%</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center"> TOTAL</th>
                                    <th style="text-align: center"> 80% </th> 
                                    <th style="text-align: center"> 20%</th> 
                                </tr>    

                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{formatMoney($total_const)}} Bs.</td>
                                    <td>{{formatMoney($total_const*0.8)}} Bs.</td>
                                    <td>{{formatMoney($total20)}} Bs.</td>
                                </tr>
                            </tbody>
                        </table>
                        <table id="20Porcent" class="table table-bordered table-striped datatable" style="width: 100%; margin-bottom: 30px;">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center">TOTAL 20%</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center"> TOTAL</th>
                                    <th style="text-align: center"> 80% </th> 
                                    <th style="text-align: center"> 20%</th> 
                                </tr>    

                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{formatMoney($total20)}} Bs.</td>
                                    <td>{{formatMoney($total20*0.8)}} Bs.</td>
                                    <td>{{formatMoney($total20*0.2)}} Bs.</td>
                                </tr>
                            </tbody>
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
        let dtButtonsCenter = [];
        let dtButtonsRight = [];
        /* ------------------------------------------------------------------------ */
        let excelButton = {
            extend: 'excel',
            className: 'btn-primary',
            text: 'Excel',
            titleAttr: 'Exportar a Excel',
            exportOptions: {
                columns: ':visible:not(.no-export)',
                orthogonal: "myExport",
            },
            title: 'Recibos',
            autoFilter: false,
        }
        dtButtonsCenter.push(excelButton)

        let pdfButton = {
            className: 'btn-success',
            text: 'PDF',
            titleAttr: 'Cear PDF',
            action: function(e, dt, node, config) {
                dt.state.clear();
                let url='{{ route('back.pdf.matricula_mes')}}';
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






