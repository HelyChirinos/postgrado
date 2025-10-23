@extends('layouts.back')

@section('title')
    &vert; Bancos-Principal 
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="card mb-2">
                <div class="card-body"  style="padding-top: 0px; padding-bottom: 0px;">
                    <div class="d-flex justify-content-between p-1 mt-3">
                        <div id="ToolbarLeft"></div>
                        <div id="ToolbarCenter"></div>
                        <div id="ToolbarRight"></div>
                    </div>
                    <div class="row mb-2 mt-2">
                        <table id="sqltable" class="styled-table mb-3 mt-0" style="width: 100%">
                            <thead >
                                <tr class="titulo">
                                    <td class="text-center no-select no-export fs-5" colspan="8" data-dt-order="disable">
                                        CIERRE DE MES - PERIODO: {{$periodo}} </td>
                                 </tr>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">F.Operación</th>
                                    <th scope="col" >Referencia</th>
                                    <th scope="col" >Descipción</th>
                                    <th scope="col">F.Valor</th>
                                    <th scope="col" >Cargo</th>
                                    <th scope="col" >Abono</th>
                                    <th scope="col" >Saldo</th>
 
                                 </tr>
                            </thead>
                            <tbody>
                                
                                @forelse($banco as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{formatFecha($item->fecha_operacion)}}</td>
                                    <td>{{$item->referencia}}</td>
                                    <td>{{$item->descripcion}}</td>
                                    <td>{{formatFecha($item->fecha_valor)}}</td>
                                    <td style="text-align: right">{{formatMoney(($item->cargo))}} Bs.</td>
                                    <td style="text-align: right">{{formatMoney(($item->abono))}} Bs.</td>
                                    <td style="text-align: right">{{formatMoney($item->saldo)}} Bs.</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="p-3 text-center text-bold">NO SE CARGO INFORMACION DEL ARCHIVO EXCEL.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>                     
                    </div>

                </div>    
            </div> 
        </div>
    </div>

@endsection


@push('scripts')
          {{-- DATATABLES BANCOS --}}
    <script type="module">

        let dtButtonsLeft = [];
        let dtButtonsRight = [];
        let dtButtonsCenter = [];
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
            title: 'BANCO',
            autoFilter: false,
        }
        dtButtonsCenter.push(excelButton)

        let pdfButton = {
            extend: 'pdfHtml5',
            className: 'btn-warning',
            text: 'PDF',
            titleAttr: 'Exportar a PDF',
            orientation: 'landscape',
            pageSize: 'LETTER',
            title: 'BANCO',
            download: 'open'

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
        /* ------------------------------------------------------------------------ */
        let uploadButton = {
            className: 'btn-success',
            text: '<i class="fa-light fa-upload" style="margin-right:8px;"></i>  Subir Archivo Mes',
            titleAttr: 'Cierre de Mes',
            enabled: true,
            action: function(e, dt, node, config) 
            {
                $.ajax({
                    method: 'GET',
                    url: "{{ route('back.bancos.upload')}}",
                    success: function(response) {
                        bootbox.dialog({
                            locale: 'nl',
                            title: 'Archivo Excel del Banco: Cierre de mes',
                            message: response,
                            size: 'lg',
                            onEscape: true,
                            backdrop: true
                        });
                    } //success
                }); // ajax               
            }  // action  

        } // uploadButton

        dtButtonsLeft.push(uploadButton)

        let diarioButton = {
            className: 'btn-success',
            text: '<i class="fa-light fa-upload" style="margin-right:8px;"></i>  Subir Archivo Diario',
            titleAttr: 'Movimientos Díarios',
            enabled: true,
            action: function(e, dt, node, config) 
            {
                $.ajax({
                    method: 'GET',
                    url: "{{ route('back.bancos.uploadDiario')}}",
                    success: function(response) {
                        bootbox.dialog({
                            locale: 'nl',
                            title: 'Archivo Excel del Banco: Movimientos Díarios',
                            message: response,
                            size: 'lg',
                            onEscape: true,
                            backdrop: true
                        });
                    } //success
                }); // ajax               
            }  // action  

        } // uploadButton


        dtButtonsLeft.push(diarioButton)

        let conciliaButton = {
            className: 'btn-success',
            text: 'Conciliación Bancaria',
            titleAttr: 'Recargar Tabla',
            action: function(e, dt, node, config) {
                dt.state.clear();

                document.location.href = '{{ route('back.bancos.conciliacion')}}';
            }
        }
        dtButtonsRight.push(conciliaButton)



        /* ------------------------------------------------------------------------ */
        let dtOverrideGlobals = {
            layout: {
                top2Start: null,
                top2End: null,    
                topEnd: 'search',
                topStart:null,
                topStart: {
                    pageLength: null,
                },
                topEnd: 'search',    
                bottomStart: 'info',
                bottomEnd: 'paging'
            },    
            lengthMenu: [25, 50, 100, { label: 'Todos', value: -1 }],
            pageLength: 25,        
            ajax: {
                url: "{{ route('back.bancos.ajax_cierre') }}",
                data: function(d) {}
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
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data.toString().padStart(4, '0');
                    }
                },
                {
                    data: 'fecha_operacion',
                    name: 'fecha_operacion',
                    type: "date",
                    className: "text-center ",
                    render: function(data) {
                        return (data) ? moment(data).utc().format('DD-MM-YYYY') : '';
                    },                    

                },
                {
                    data: 'referencia',
                    name: 'referencia',
                    type: 'text',
                    className: "text-center",
                },
                {
                    data: 'descripcion',
                    name: 'descripcion',
                    type: 'text',
                },                
                {
                    data: 'fecha_valor',
                    name: 'fecha_valor',
                    type: "date",
                    className: "text-center ",
                    render: function(data) {
                        return (data) ? moment(data).utc().format('DD-MM-YYYY') : '';
                    },
                },
                {
                    data: 'cargo',
                    name: 'cargo',
                    type: 'numeric',
                    className: "text-center ",
                    render: function(data) {
                        return ( data === 0 || data === 0.00 ) ? '' : $.fn.dataTable.render.number(null, null, 2 ,null, ' Bs.' ).display( data );
                    },
                },
                {
                    data: 'abono',
                    name: 'abono',
                    type: 'numeric',
                    className: "text-center ",
                    render: function(data) {
                        return ( data === 0 || data === 0.00 ) ? '' : $.fn.dataTable.render.number(null, null, 2 ,null, ' Bs.' ).display( data );
                    },

                },
                {
                    data: 'saldo',
                    name: 'saldo',
                    type: 'numeric',
                    className: "text-center ",
                    render: function(data) {
                        return ( data === 0 || data === 0.00 ) ? '' : $.fn.dataTable.render.number(null, null, 2 ,null, ' Bs.' ).display( data );
                    },
                },
            ],
                

            preDrawCallback: function(settings) {
                oTable.columns.adjust();
            },
        };
        /* ------------------------------------------- */

        let oTable = $('#sqltable').DataTable(dtOverrideGlobals);
        /* ------------------------------------------------------------------------ */

        new $.fn.dataTable.Buttons(oTable, {
            name: 'BtnGroupLeft',
            buttons: dtButtonsLeft
        });

        new $.fn.dataTable.Buttons(oTable, {
            name: 'BtnGroupRight',
            buttons: dtButtonsRight
        });

        new $.fn.dataTable.Buttons(oTable, {
            name: 'BtnGroupCenter',
            buttons: dtButtonsCenter
        });        

        oTable.buttons('BtnGroupLeft', null).containers().appendTo('#ToolbarLeft');

        oTable.buttons('BtnGroupRight', null).containers().appendTo('#ToolbarRight');

        oTable.buttons('BtnGroupCenter', null).containers().appendTo('#ToolbarCenter');



    </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" type="text/javascript"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" type="text/javascript"></script>

@endpush


