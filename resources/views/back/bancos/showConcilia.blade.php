@extends('layouts.back')

@section('title')
    &vert; Conciliación
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="card mb-0" style="border:none;">
                <div class="card-body"  style="padding-top: 0px; padding-bottom: 0px;">
                    <div class="d-flex justify-content-between p-1 mt-3">
                        <div id="ToolbarLeft1"></div>
                        <div id="ToolbarCenter1"></div>
                        <div id="ToolbarRight1"></div>
                    </div>
                </div>    
        
            </div>    

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-2">
                    <div class="card-body"  style="padding-top: 0px; padding-bottom: 0px;">
                        <div class="d-flex justify-content-between p-1 mt-3">
                            <div id="ToolbarLeft"></div>
                            <div id="ToolbarCenter"></div>
                            <div id="ToolbarRight"></div>
                        </div>                        
                        <div class="row mb-2 mt-1">
                            <table id="concilia" class="styled-table mb-3 mt-3 table-bordered" style="width: 100%">
                                <thead >
                                    <tr class="titulo text-center">
                                        <th class="text-center no-select no-export fs-5" colspan="7" data-dt-order="disable">MOVIMIENTOS CONCILIADOS</th>
                                    </tr>
                                    <tr >
                                        <th style="text-align: center;" scope="col" >Ref.</th>
                                        <th style="text-align: center;" scope="col" >Recibo</th>
                                        <th style="text-align: center;" scope="col" >No.Doc.</th>
                                        <th style="text-align: center;" scope="col" >Nombre</th>
                                        <th style="text-align: center;" scope="col" >F.Banco</th>
                                        <th style="text-align: center;" scope="col" >Banco</th>
                                        <th style="text-align: center;" scope="col" >Recibo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse($conciliados as $item)
                                    <tr>
                                        <td>{{$item->referencia}}</td>
                                        <td>{{$item->recibo}}</td>
                                        <td>{{$item->no_doc}}</td>
                                        <td style="font-size: 10px;">{{$item->nombre}}</td>
                                        <td>{{formatFecha($item->banco_fecha)}}</td>
                                        <td style="text-align: right">{{formatMoney(($item->banco_monto))}} Bs.</td>
                                        <td style="text-align: right">{{formatMoney(($item->deposito_monto))}} Bs.</td>
                                         
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="p-3 text-center text-bold">NO HAY CONCIDENCIA CON EL BANCO.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>                     
                        </div>

                    </div>    
                </div> 
            </div>    
            <div class="col-md-6">
                <div class="card mb-2">
                    <div class="card-body"  style="padding-top: 0px; padding-bottom: 0px;">
                        <div class="d-flex justify-content-between p-1 mt-3">
                            <div id="ToolbarLeft2"></div>
                            <div id="ToolbarCenter2"></div>
                            <div id="ToolbarRight2"></div>
                        </div>                        
                        <div class="row mb-2 mt-1">
                            <table id="transito" class="styled-table mb-3 mt-3" style="width: 100%">
                                <thead >
                                    <tr class="titulo">
                                        <th colspan="4" class="text-center no-select no-export fs-5" data-dt-order="disable">MOVIMIENTOS EN TRANSITO</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">F.Operación</th>
                                        <th scope="col" class="text-center" >Ref.</th>
                                        <th scope="col" >Descipción</th>
                                        <th scope="col" >Abono</th>
    
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse($transito as $item)
                                    <tr>
                                        <td>{{formatFecha($item->fecha_operacion)}}</td>
                                        <td class="text-center">{{$item->referencia}}</td>
                                        <td  style="font-size: 10px;">{{$item->descripcion}}</td>
                                        <td style="text-align: right">{{formatMoney(($item->abono))}} Bs.</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="p-3 text-center text-bold">NO HAY MOVIMIENTOS EN TRANSITO.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>                     
                        </div>

                    </div>    
                </div> 
            </div>                
        </div>
    </div>

@endsection

@push('scripts')
          {{-- DATATABLES CONCILIACION --}}
    <script type="module">
        let dtButtonsCenter = [];
        let dtButtonsLeft = [];
        let dtButtonsRight = [];
        let resumen ="{{$resumen->id}}";
        let periodo ="{{$periodo}}";
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
            title: 'BANCOS',
            autoFilter: false,
        }
        dtButtonsCenter.push(excelButton)

        let pdfButton = {
            extend: 'pdfHtml5',
            className: 'btn-warning',
            text: 'PDF',
            titleAttr: 'Exportar a PDF',
            orientation: 'portrait',
            pageSize: 'LETTER',
            title: 'SIPADU - BANCOS',
            download: 'open'

        }
        dtButtonsCenter.push(pdfButton)
        let printButton = {
            extend: 'print',
            className: 'btn-secondary',
            text: 'Printer',
            titleAttr: 'Imptimir',
            title: 'SIPADU - BANCOS',
            exportOptions: {
                columns: ':visible:not(.no-export)',
                orthogonal: "myExport",
            },
            //autoPrint: false,
            orientation: 'portrait',
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
        /* ------------------- */

        let cierreButton = {
            className: 'btn-success',
            text: 'Ver Resumen',
            titleAttr: 'Ver Reumen',
            enabled: true,
            action: function(e, dt, node, config) 
            {
                let url = "{{ route('back.bancos.resumen') }}";
                url = url+'?periodo='+periodo+'&resumen='+resumen; 
                document.location.href=url;               
                window.location = url;
            }  // action  
        }
        dtButtonsRight.push(cierreButton)

        let BackButton = {
            className: 'btn-success',
            text: "Regresar",
            titleAttr: 'Regrasar a Bancos',
            action: function(e, dt, node, config) {
                dt.state.clear();

                document.location.href = '{{ route('back.bancos.index')}}';
            }
        }
        dtButtonsLeft.push(BackButton)
      
        /* ------------------------------------------------------------------------ */
        let dtOverrideGlobals = {
            serverSide: false,
            retrieve: false,
            layout: null,
            lengthMenu: null,
            ordering: false,
            oLanguage: {
                sEmptyTable: "Tabla Vacia"
            },
            layout: {
                top2Start: null,
                top2End: null,    
                topEnd: 'search',
                topStart: {
                    pageLength: {
                        menu:  [[25, 50, 100, -1],[25, 50, 100, 'Todos']]
                    },
                },
                bottomStart: 'info',
                bottomEnd: 'paging'
            },    
            pageLength: 25,        

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

        let oTable = $('#concilia').DataTable(dtOverrideGlobals);

        new $.fn.dataTable.Buttons(oTable, {
            name: 'BtnGroupCenter',
            buttons: dtButtonsCenter
        });               
        new $.fn.dataTable.Buttons(oTable, {
            name: 'BtnGroupRight',
            buttons: dtButtonsRight
        });
        new $.fn.dataTable.Buttons(oTable, {
            name: 'BtnGroupLeft',
            buttons: dtButtonsLeft
        });    
        oTable.buttons('BtnGroupCenter', null).containers().appendTo('#ToolbarCenter');
        oTable.buttons('BtnGroupRight', null).containers().appendTo('#ToolbarRight1');
        oTable.buttons('BtnGroupLeft', null).containers().appendTo('#ToolbarLeft1');
        
        /* ------------------------------------------------------------------------ */

        let Table2 = $('#transito').DataTable(dtOverrideGlobals);
        new $.fn.dataTable.Buttons(Table2, {
            name: 'BtnGroupCenter',
            buttons: dtButtonsCenter
        });           

        Table2.buttons('BtnGroupCenter', null).containers().appendTo('#ToolbarCenter2');
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" type="text/javascript"></script>

@endpush

