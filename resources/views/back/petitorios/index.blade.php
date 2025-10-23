@extends('layouts.back')

@section('title')
    &vert; Petitorios
@endsection

@section('content')

<style>
.btn-group-xs > .btn, .btn-xs {
padding: 1px 5px;
font-size: 12px;
line-height: 1.5;
border-radius: 3px;
}

.alerta {
    font-size: 16px;
    color: white;
    padding: 10px;
    text-align: center;
}
</style>

<div class="row mb-4 mt-2">
    <div class="col-lg-4"> </div>
    <div class="col-lg-4"> 

        <table class="table table-bordered table-striped table-sm table-hover dataTable">
            <thead>
                <tr>
                    <td class="text-center">
                        DONATIVOS
                    </td>
                    <td class="text-center">
                        PETITORIOS
                    </td>
                    <td class="text-center">
                        SALDO
                    </td>                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                      {{$tot_donativos}} Bs.
                    </td>
                    <td class="text-center">
                        {{{$tot_petitorios}}} Bs.
                    </td>
                    <td class="text-center">
                        {{{$total}}}  Bs.
                   </td>                    
                </tr>
            </tbody>
       </table>


    </div>
    <div class="col-lg-4"> </div>
</div>



<div class="row mb-3">
    <div class="col-1"></div>
    <div class="col-10">
        <div id="petitorios_card " class="card mb-3">
            <div class="card-header text-white bg-primary d-print-none">
                <div class="row">
                    <div class="col fs-5 text-center">Petitorios</div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                <div class="col">
                        <table id="sqltable" class="table table-bordered table-striped table-sm table-hover dataTable" style="width: 80%">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col" width="4%">ID</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">No. Doc.</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Status</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-1"></div>
</div>    

<div class="row mb-3">
    <div class="col-1"></div>
    <div class="col-10">
        <div id="petitorios_card " class="card mb-3">
            <div class="card-header text-white bg-primary d-print-none">
                <div class="row">
                    <div class="col fs-5 text-center">Donativos</div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                <div class="col">
                        <table id="tableDonativo" class="table table-bordered table-striped table-sm table-hover dataTable" style="width: 80%">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col" width="4%">ID</th>
                                    <th scope="col">No. Doc.</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Recibo</th>                                    
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col"></th>                                              

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-1"></div>
</div>    

@endsection

@push('scripts')
          {{-- DATATABLES PETITORIOS --}}
    <script type="module">

        /* ------------------------------------------------------------------------ */
        let dtOverrideGlobals = {
            layout: {
                top2Start: null,
                top2End: null,    
                topEnd: 'search',
                topStart: 'pageLength',
                topEnd: 'search',    
                bottomStart: 'info',
                bottomEnd: 'paging'
            },            
            ajax: {
                url: "{{ route('back.petitorios.index') }}",
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
                    data: 'codigo',
                    name: 'codigo',
                    type: "text",
                    className: "text-center ",

                },
                {
                    data: 'no_doc',
                    name: 'no_doc',
                    type: 'text',
                },
                {
                    data: 'nombre',
                    name: 'nombre',
                    type: 'text',
                },
                {
                    data: 'fecha',
                    name: 'fecha',
                    type: "date",
                    className: "text-center ",
                    render: function(data) {
                        return moment(data).utc().format('DD-MM-YYYY');
                    },
                },
                {
                    data: 'monto',
                    name: 'monto',
                    type: 'numeric',
                    className: "text-center ",
                    render: DataTable.render.number(null, null, 2 ,null, ' Bs.' ), 
                },
                {
                    data: 'status',
                    name: 'status',
                    type: 'text',
                    className: "text-center ",
                },
                {
                    data: null,
                    searchable: false,
                    sortable: false,
                    
                    className: 'dt-center  no-select no-export',
                    orderable: false,
                    render: function ( data, type, row, meta ) {
                        if (row.status=='EN ESPERA') {
                            return  '<button type="button" class="btn btn-primary btn-xs select-status"> <i class="fa-duotone fa-person-circle-check fa-fw"></i></button>';
                        } else {
                            return '';
                        }   
                    }
                },                               
                {
                    data: null,
                    searchable: false,
                    sortable: false,
                    className: 'dt-center print-recibo no-select no-export',
                    defaultContent: '<i class="fa-light fa-print"></i>',
                    orderable: false
                },  

            ],
                
            ordering: true,
            order: [
                [1, 'desc']
            ],
            preDrawCallback: function(settings) {
                oTable.columns.adjust();
            },
        };
        /* ------------------------------------------- */

        let oTable = $('#sqltable').DataTable(dtOverrideGlobals);
        /* ------------------------------------------------------------------------ */


        $('#sqltable tbody').on('click', '.select-status', function() {
            const data = oTable.row($(this).closest('tr')).data();
            console.log(data);
            let id = data.id;
            let codigo = data.codigo;
            bootbox.prompt({
                buttons: {
                    confirm: {
                        label: 'Cambiar'
                    },
                    cancel: {
                    label: 'Cancelar',

                    }
                },
                title: 'Seleccione Decisión',
                inputType: 'select',
                inputOptions: [{
                text: 'Escoja opción...',
                value: ''
                },
                {
                text: 'APROBADO',
                value: 'APROBADO'
                },
                {
                text: 'RECHAZADO',
                value: 'RECHAZADO'
                }],
                callback: function (result) {
                    if (result === null) {
                        return;} 
                    if (result === '') {
                        return false;
                    }
                    console.log(result);

                    $.ajax({
                        method: 'POST',
                        url: "{{route('back.petitorios.accion') }}",
                        data: {
                            id: id,
                            accion:result,   
                        },
                        success: function(response) {
                        
                            oTable.ajax.reload();
                            showToast({
                                type: 'success',
                                title: 'Accion ...',
                                message: 'El Petitorio se actualizo.',
                            });
                            if (result == 'APROBADO') {
                                bootbox.alert({
                                message: 'Código de Aprobación:<br>'+codigo,
                                className:'alerta',

                                size: 'small'
                                });
                            }

                        },
                        error: function(result) {
                            alert('Tipo de Error:' + result.status+' '+result.responseText);
                        }
                    });



                    
                }
                });

        });





    </script>


     {{-- DATATABLES DONATIVO --}}
     <script type="module">

        /* ------------------------------------------------------------------------ */
        let dtOverrideDonativo = {
            layout: {
                top2Start: null,
                top2End: null,    
                topEnd: 'search',
                topStart: 'pageLength',
                topEnd: 'search',    
                bottomStart: 'info',
                bottomEnd: 'paging'
            },                 
            ajax: {
                url: "{{ route('back.petitorios.donativos') }}",
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
                    data: 'no_doc',
                    name: 'no_doc',
                    type: 'text',
                },
                {
                    data: 'nombre',
                    name: 'nombre',
                    type: 'text',
                },
                {
                    data: 'recibo',
                    name: 'recibo',
                    type: 'text',
                },                
                {
                    data: 'fecha',
                    name: 'fecha',
                    type: "date",
                    className: "text-center ",
                    render: function(data) {
                        return moment(data).utc().format('DD-MM-YYYY');
                    },
                },
                {
                    data: 'monto',
                    name: 'monto',
                    type: 'numeric',
                    className: "text-center ",
                    render: DataTable.render.number(null, null, 2 ,null, ' Bs.' ), 
                },
                {
                    data: null,
                    searchable: false,
                    sortable: false,
                    className: 'dt-center print-recibo no-select no-export',
                    defaultContent: '<i class="fa-light fa-print"></i>',
                    orderable: false
                },  

            ],
                
            ordering: true,

            preDrawCallback: function(settings) {
                oTableDonar.columns.adjust();
            },
        };
        /* ------------------------------------------- */

        let oTableDonar = $('#tableDonativo').DataTable(dtOverrideDonativo);
        /* ------------------------------------------------------------------------ */

    </script>


@endpush
