

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
                        <table id="sqltable" class="styled-table mb-3 mt-0 table-bordered">
                            <thead >
                                <tr class="titulo">
                                    <td  style="font-size: 14px" class="text-center no-select no-export " colspan="5" data-dt-order="disable">
                                        MOVIMIENTOS DIARIOS - PERIODO: {{$periodo}} </td>
                                 </tr>
                                <tr style="width: 100%">
                                    <th ><i class="fa-light fa-check-to-slot"></i></th>
                                    <th >Fecha</th>
                                    <th style="text-align: center;"  >Referencia</th>                                    
                                    <th  >Concepto</th>
                                    <th  >Importe</th>
 
                                 </tr>
                            </thead>
                            <tbody>
                                @forelse ($diarios as $item )
                                    <tr>
                                        <td></td>
                                        <td>{{formatFecha($item->f_operacion)}}</td>
                                        <td style="text-align: center;">{{$item->no_doc}}</td>
                                        <td style="white-space: nowrap;">{{$item->concepto}}</td>
                                        <td>{{formatMoney($item->importe)}}</td>
                                    </tr>
                                @empty
                                    <td colspan="4"> Debe Cargar el archivo Diario del Banco</td>
                                                             @endforelse
                            </tbody>
                        </table>                     
                    </div>

                </div>    
            </div> 
        </div>
    </div>



          {{-- DATATABLES BANCOS --}}
    <script type="module">

        let linea ="{{$linea}}";
    /* ------------------------------------------------------------------------ */
        let dtOverrideGlobals = {
            serverSide: false,
            retrieve: false,
            processing: false,
            stateSave: true,
            stateLoadParams: function (settings, data) {
                data.search.search = '';
            },            
            layout: {
                topStart: {
                    buttons: [
                        {
                            text: 'Seleccionar',
                            className: 'btn-primary',
                            titleAttr: 'Seleccionar',
                            action: function (e, dt, node, config) {
                                var rows = dt.rows({ selected: true }).count();
                                if (rows>0) {
                                    let ref='';
                                    let fecha='';
                                    let monto = 0;
                                    for (var i = 0; i < oTable.rows('.selected').data().length; i++) {
                                        ref = oTable.rows('.selected').data()[i][2];
                                        fecha = oTable.rows('.selected').data()[i][1];
                                        monto = oTable.rows('.selected').data()[i][4];
                                    } 
                                    const [dia, mes, ano] = fecha.split("-");
                                    let fecha_def = `${ano}-${mes}-${dia}`;                               
                                    $('#deposito'+linea).val(ref);
                                    $('#fecha'+linea).val(fecha_def);
                                    $('#monto'+linea).val(monto);
                                    bootbox.hideAll();
                                } else {
                                    const mensaje = "<p style='color:#2F7127; text-align:center;'>Debe selecionar una fila  <i class='fa-regular fa-square-check fa-xl'></i> o presione <i class='fa-regular fa-x '></i> para Cancelar</p>"; 
                                    bootbox.alert(mensaje).find('.modal-content').css({'background-color': '#fff', 'font-weight' : 'bold', color: '#F00', 'font-size': '14px', 'font-weight' : 'bold'} );
                                }    
                            }
                        }
                    ]   
                },
                top2Start:null,
                top2End: null,    
                topEnd: 'search',
                bottomStart:null,    
            },    
            paging: false,        
            select: false,     
            ordering: false,       
            language: {
                url: "{{ asset('json/datatables/i18n/es-ES.json') }}",
                searchPlaceholder: "Cédula del Depositante",
                paginate: {
                    next: '<i class="fa fa-forward" title="próximo"></i>',
                    previous: '<i class="fa fa-backward" title="anterior"></i>',
                    first: '<i class="fa fa-step-backward" title="primero"></i>',
                    last: '<i class="fa fa-step-forward" title="último"></i>',
                }

            },
            preDrawCallback: function(settings) {
                oTable.columns.adjust();
            },

            columnDefs: [
                {
                    orderable: false,
                    render: DataTable.render.select(),
                    targets: 0
                }
            ],
            select: {
                style: 'os',
                selector: 'td:first-child',
                headerCheckbox: false
            },            
            
        };
        /* ------------------------------------------- */

        let oTable = $('#sqltable').DataTable(dtOverrideGlobals);
        /* ------------------------------------------------------------------------ */

        /* ------------------------------------------------------------------------ */
   
    </script>





